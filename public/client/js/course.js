$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
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
                }
            },
            { data: 'description'},
            { data: 'code'},
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

    $(document).on('click', '#course-add', function() {
        $('#course-form').trigger("reset");         
        $('#action-course').val('Add');
        $.ajax({
            type:"GET",
            url:"/category/college", 
            success:function(res)
            {       
                if(res)
                {
                    $('#college').empty();
                    $("#college").append('<option value="">Select College</option>');
                    $.each(res,function(key,value){
                        $("#college").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        });
        $('.modal-title').html("Add course");
        $('#save-data').text("Submit");
    });

    $('body').on('click', '#edit-course', function () {
        var id = $(this).data('id');
        $('#action-course').val('Edit');
        $.get("data/course/" + id, function (data) { 
            $('#course-form').trigger("reset");   
            $.ajax({
                type:"GET",
                url:"/category/college", 
                success:function(res)
                {       
                    if(res)
                    {
                        $('#college').empty();
                        $("#college").append('<option value="">Select College</option>');
                        $.each(res,function(key,value){
                            $("#college").append('<option value="'+key+'">'+value+'</option>');
                        });
                        var option = new Option(data.colleges[0].description, data.colleges[0].id, true, true);
                        $('#college').val(data.colleges[0].id).trigger('change'); 
                    }
                }
            });    
            $('#description').val(data.description);
            $('#code').val(data.code);
            $('#idcourse').val(data.id)
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
            $.ajax({
                url: "data/course",
                method:"POST",
                data: info,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'COURSE ADDED', {timeOut: 3000});
                        coursetable.ajax.reload();
                        coursetable.draw();
                        $("#add-course .close").click();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');               }
                    if(data.error)
                    {
                        toastr.error(data.error, 'ERROR', {timeOut: 3000});
                         $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');
                    }
                },
                error: function(jqXHR) {
                    toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                    $('#save-data').prop('disabled', false)
                    .html("Submit")
                    .removeClass('uploading');
                }
            })
        }
        if(action == "Edit")
        {
            var id = $('#idcourse').val();
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
                    if(data.error)
                    {
                        toastr.error(data.error, 'ERROR', {timeOut: 3000});
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
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
        $.ajax({
            url: "data/course/" + course,
            type: "POST",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                coursetable.ajax.reload();
                coursetable.draw();
                $("#restore .close").click();
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');  
            }
        });
    });
});
