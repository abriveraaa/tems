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

    $('#toolcategory').select2({ width: '100%' });

    $(document).on('click', '#toolname-add', function() {
        $('#toolname-form').trigger("reset");         
        $('#action-toolname').val('Add');
        $.ajax({
            type:"GET",
            url:"/category/toolcategories", 
            success:function(res)
            {       
                if(res)
                {
                    $('#toolcategory').empty();
                    $("#toolcategory").append('<option value="">Select Tool Category</option>');
                    $.each(res,function(key,value){
                        $("#toolcategory").append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            }
        });
        $('.modal-title').html("Add toolname");
        $('#save-data').text("Submit");
    });

    $('body').on('click', '#edit-toolname', function () {
        var id = $(this).data('id');
        $('#action-toolname').val('Edit');
        $.get("data/toolname/" + id, function (data) { 
            $('#toolname-form').trigger("reset");   
            $.ajax({
                type:"GET",
                url:"/category/toolcategories", 
                success:function(res)
                {       
                    if(res)
                    {
                        $('#toolcategory').empty();
                        $("#toolcategory").append('<option value="">Select Tool Category</option>');
                        $.each(res,function(key,value){
                            $("#toolcategory").append('<option value="'+key+'">'+value+'</option>');
                        });
                        var option = new Option(data.categories[0].description, data.categories[0].id, true, true);
                        $('#toolcategory').val(data.categories[0].id).trigger('change'); 
                    }
                }
            });    
            $('#description').val(data.description);
            $('#code').val(data.code);
            $('#idtoolname').val(data.id)
            $('.modal-title').html("Edit toolname");
            $('#save-data').text("Update");
        })
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
            $.ajax({
                url: "data/toolname",
                method:"POST",
                data: info,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'toolname ADDED', {timeOut: 3000});
                        toolnametable.ajax.reload();
                        toolnametable.draw();
                        $("#add-toolname .close").click();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');                      }
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
            var id = $('#idtoolname').val();
            $.ajax({
                url: "data/toolname/" + id,
                method:"PUT",
                data: info,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'toolname UPDATED', {timeOut: 3000});
                        toolnametable.ajax.reload();
                        toolnametable.draw();
                        $("#add-toolname .close").click();
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
                error: function(jqXHR) {
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
        $.ajax({
            url: "data/toolname/" + toolname,
            type: "POST",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 3000});
                toolnametable.ajax.reload();
                toolnametable.draw();
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
