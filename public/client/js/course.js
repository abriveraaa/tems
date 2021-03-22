$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let loadCollege = async() => {
        
        const colleges = await $.get("/category/college", function(data){});
    
        $('#college').empty();
        $("#college").append('<option value="">Select College</option>');
        $.each(colleges,function(key,value){
            $("#college").append('<option value="'+key+'">'+value+'</option>');
        });
    }
    
    var coursetable = $('#course-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[4, "desc"]],
        ajax: 'data/course',
        columns: [
            { data: "colleges",
                "render": function ( data, type, row ) {
                    if(data == null || data == ''){
                        return '';
                    }else{
                        return data[0].code;
                    }
                },
                searchable: true
            },
            { data: 'description', searchable: true },
            { data: 'code', searchable: true },
            { data: "deleted_at", visible: false },
            { data: "updated_at", visible: false },
            { data: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function( row, data, dataIndex){
            $(row).addClass('deleted');
            if( data.deleted_at !=  null){
                $(row).addClass('bannedClass');
            }else if(data.colleges == ''){
                $(row).addClass('bannedClass');
            }
        },
        "rowCallback": function( row, data, index ) {
            if (data.colleges.length == 0) {
                $(row).hide();
            }
        },
    });

    $('#college').select2({ width: '100%' });

    loadCollege();

    $(document).on('click', '#course-add', function() {
        $('#course-form').trigger("reset");         
        $('#action-course').val('Add');
        $('#college').val("").trigger("change");
        $('.modal-title').html("Add course");
        $('#save-data').text("Submit");
    });

    $('body').on('click', '#edit-course', function () {
        var id = $(this).data('id');
        $('#action-course').val('Edit');
        $.get("data/course/" + id, function (data) { 
            $('#course-form').trigger("reset");   
            data.map((result) => {
                console.log(result);
                $('#description').val(result.description);
                $('#code').val(result.code);
                $('#id').val(result.id)
                $('#college').val(result.colleges[0].id).trigger('change');  
            });
            
            $('.modal-title').html("Edit course");
            $('#save-data').text("Update");
        })
    });

    $('body').on('click', '#del-course', function () {
        var id = $(this).data('id');
        $('.modal-title').text("DELETE RECORDS");
        $('#del-id').val(id);  
    });

    $('body').on('click', '#res-course', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });

    $('#save-data').click(function(e){
        e.preventDefault();
        var action = $('#action-course').val();
        var info = $('#course-form').serialize();
         $('#save-data').prop('disabled', true)
        .html("")
        .addClass('uploading');
        if(action == "Add")
        {
            $.post("data/course", info)
            .done(function(data){
                toastr.success(data.success, 'COURSE ADDED', {timeOut: 3000});
                coursetable.ajax.reload();
                coursetable.draw();
                $("#add-course .close").click();
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');  
            })
            .fail(function(data){
                var errors = data.responseJSON.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += value[0]; 
                });
                toastr.error(
                    errorsHtml, 
                    'ERROR', 
                    {timeOut: 3000}
                );
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');
            });
        }
        if(action == "Edit")
        {
            var id = $('#id').val();
            $.ajax({
                url: "data/course/" + id,
                method:"PUT",
                data: info,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'COURSE UPDATED', {timeOut: 3000});
                        coursetable.ajax.reload();
                        coursetable.draw();
                        $("#add-course .close").click();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                    }
                },
                error: function(data) {
                    var errors = data.responseJSON.errors;
                    var errorsHtml= '';
                    $.each( errors, function( key, value ) {
                        errorsHtml += value[0]; 
                    });
                    toastr.error(
                        errorsHtml, 
                        'ERROR', 
                        {timeOut: 3000}
                    );
                    $('#save-data').prop('disabled', false)
                    .html("Submit")
                    .removeClass('uploading');  
                }
            })
        }
    });

    $('body').on('click', '#confirm-yes', function () {
        var college = $('#del-id').val();
        $.ajax({
            url: "data/course/" + college,
            type: "DELETE",
            success: function (data) {
                toastr.warning(data.success, 'Deleted', {timeOut: 1000});
                coursetable.ajax.reload();
                coursetable.draw();
                $("#delete .close").click();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');  
            }
        });
    });  

    $(document).on('click', '#confirm-res', function () {
        var course = $('#res-id').val();
        $.post("data/course/" + course, function(data){})
        .done(function(data){
            toastr.success(data.success, 'Restored', {timeOut: 1000});
            coursetable.ajax.reload();
            coursetable.draw();
            $("#restore .close").click();
        })
        .fail(function(jqXHR){
            toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
            $('#save-data').prop('disabled', false)
            .html("Submit")
            .removeClass('uploading');  
        });
    });
});
