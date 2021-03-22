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

    $('#add-categories').click(function() {
        $('#action').val('1');
        $('#categories-form').trigger("reset");         
        $('#description').val('');
        $('#code').val('');
        $('#id').val('')
        $('.modal-title').html("Submit");
        $('#save-data').text("Submit");
    });

    var categoriestable = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[1, "asc"]],
        ajax: 'data/categories',
        columns: [
            { data: 'description'},
            { data: "deleted_at", visible: false },
            { data: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function( row, data, dataIndex){
            $(row).addClass('deleted');
            if( data.deleted_at !=  null){
                $(row).addClass('bannedClass');
                
            }
        },
    });

    $('body').on('click', '.edit-categories', function () {
        var id = $(this).data('id');
        $('#action').val('2');
        $.get("data/categories/" + id, function (data) { 
            $('#categories-form').trigger("reset");         
            $('#description').val(data.description);
            $('#id').val(data.id)
            $('.modal-title').html("Edit categories");
            $('#save-data').text("Update");
        })
    });

    $('#save-data').click(function(event) {
        event.preventDefault();
        var action = $('#action').val();
         $('#save-data').prop('disabled', true)
        .html("")
        .addClass('uploading');
        if(action == 1)
        {
            var info = $('#categories-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/categories",
                method: "POST",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#categories-form').trigger('reset');
                        $('.show').hide();
                        toastr.success('New record has been saved successfully', 'SAVED', {timeOut: 5000});
                        categoriestable.ajax.reload();
                        categoriestable.draw();
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
            });
            $('#categories-form').trigger("reset"); 
        }
        if(action == 2)
        {
            var id = $('#id').val();
            var info = $('#categories-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/categories/" + id,
                method: "PUT",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#categories-form').trigger('reset');
                        $('.show').hide();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                        toastr.success('Record has been updated successfully', 'SAVED', {timeOut: 5000});
                        categoriestable.ajax.reload();
                        categoriestable.draw();
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
            });
        }
    })

    $('body').on('click', '.del-categories', function () {
        var id = $(this).data('id');
        $('.modal-title').text("DELETE RECORDS");
        $('#del-id').val(id);  
    });  

    $('body').on('click', '#confirm-yes', function () {
        var categories = $('#del-id').val();
        $.ajax({
            url: "data/categories/" + categories,
            type: "DELETE",
            success: function (data) {
                toastr.warning(data.success, 'Deleted', {timeOut: 1000});
                categoriestable.ajax.reload();
                categoriestable.draw();
                $("#delete .close").click();
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    })

    $('body').on('click', '.res-categories', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });  

    $(document).on('click', '#confirm-res', function () {
        var categories = $('#res-id').val();
        $.ajax({
            url: "data/categories/" + categories,
            type: "POST",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                categoriestable.ajax.reload();
                categoriestable.draw();
                $("#restore .close").click();
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');  
            }
        });
    })
});
