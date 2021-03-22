$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).keypress(function(event){
        if (event.which == '13') {
        event.preventDefault();
        }
    });

    $('#toolcategory').select2({ width: '100%' });

    var toolnametable = $('#toolname-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[4, "desc"]],
        ajax: 'data/toolname',
        columns: [
            { data: "categories",
                "render": function ( data, type, row ) {
                    if(data == null || data == ''){
                        return '';
                    }else{
                        return data[0].description;
                    }
                }
            },
            { data: 'description'},
            { data: "deleted_at", visible: false },
            { data: "updated_at", visible: false },
            { data: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function( row, data, dataIndex){
            $(row).addClass('deleted');
            if( data.deleted_at !=  null){
                $(row).addClass('bannedClass');
            }else if(data.categories == ''){
                $(row).addClass('bannedClass');
            }
        },
        "rowCallback": function( row, data, index ) {
            if (data.categories.length == 0) {
                $(row).hide();
            }
        },
    });

    let addTool = async() => {
        const add = await $.get("/category/toolcategories", function(data){});
        $('#toolcategory').empty();
        $("#toolcategory").append('<option value="">Select Tool Category</option>');
        $.each(add,function(key,value){
            $("#toolcategory").append('<option value="'+key+'">'+value+'</option>');
        });
    };

    let editToolName = async(id) => {
        const edit = await $.get("data/toolname/" + id, function (data) {});
        $('#toolname-form').trigger("reset");
        $('#toolcategory').empty();
        $("#toolcategory").append('<option value="">Select Tool Category</option>');
        $('#description').val(edit.description);
        $('#code').val(edit.code);
        $('#idtoolname').val(edit.id)
        
        const toolcategories = await $.get("/category/toolcategories", function(data){});
        $.each(toolcategories,function(key,value){
            $("#toolcategory").append('<option value="'+key+'">'+value+'</option>');
        });
        $('#toolcategory').val(edit.categories[0].id).trigger('change'); 
    };

    $(document).on('click', '#toolname-add', function() {
        $('#toolname-form').trigger("reset");         
        $('#action-toolname').val('Add');
        addTool();
        $('.modal-title').html("Add toolname");
        $('#save-data').text("Submit");
    });

    $('body').on('click', '#edit-toolname', function () {
        var id = $(this).data('id');
        $('#action-toolname').val('Edit');
        editToolName(id);
        $('.modal-title').html("Edit toolname");
        $('#save-data').text("Update");
    });

    $('body').on('click', '#del-toolname', function () {
        var id = $(this).data('id');
        $('.modal-title').text("DELETE RECORDS");
        $('#del-id').val(id);  
    });

    $('body').on('click', '#res-toolname', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });

    $('#save-data').click(function(e){
        e.preventDefault();
        var action = $('#action-toolname').val();
        var info = $('#toolname-form').serialize();
        $('#save-data').prop('disabled', true)
        .html("")
        .addClass('uploading');
        if(action == "Add")
        {
            $.post("data/toolname", info)
            .done(function(data){
                toastr.success(data.success, 'ADDED', {timeOut: 3000});
                toolnametable.ajax.reload();
                toolnametable.draw();
                $("#add-toolname .close").click();
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
            var id = $('#idtoolname').val();
            $.ajax({
                url: "data/toolname/" + id,
                method:"PUT",
                data: info,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'UPDATED', {timeOut: 3000});
                        toolnametable.ajax.reload();
                        toolnametable.draw();
                        $("#add-toolname .close").click();
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
            url: "data/toolname/" + college,
            type: "DELETE",
            success: function (data) {
                toastr.warning(data.success, 'Deleted', {timeOut: 3000});
                toolnametable.ajax.reload();
                toolnametable.draw();
                $("#delete .close").click();
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');  
            }
        });
    });  

    $(document).on('click', '#confirm-res', function () {
        var toolname = $('#res-id').val();
        $.post("data/toolname/" + toolname, function(data){})
        .done(function(data){
            toastr.success(data.success, 'Restored', {timeOut: 3000});
            toolnametable.ajax.reload();
            toolnametable.draw();
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
