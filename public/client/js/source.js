$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#add-source').click(function() {
        $('#action').val('1');
        $('#source-form').trigger("reset");         
        $('#description').val('');
        $('#id').val('')
        $('.modal-title').html("Add source");
        $('#save-data').html("Submit");
    });

    var sourcetable = $('#source-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[0, "asc"]],
        ajax: 'data/source',
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

    $('body').on('click', '.edit-source', function () {
        var id = $(this).data('id');
        $('#action').val('2');
        $.get("data/source/" + id, function (data) { 
            $('#source-form').trigger("reset");         
            $('#description').val(data[0].description);
            $('#id').val(data[0].id)
            $('.modal-title').html("Edit source");
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
            var info = $('#source-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/source",
                method: "POST",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#source-form').trigger('reset');
                        $('.show').hide();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                        toastr.success('New record has been saved successfully', 'SAVED', {timeOut: 3000});
                        sourcetable.ajax.reload();
                        sourcetable.draw();
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
            $('#source-form').trigger("reset"); 
        }
        if(action == 2)
        {
            var id = $('#id').val();
            var info = $('#source-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/source/" + id,
                method: "PUT",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#source-form').trigger('reset');
                        $('.show').hide();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                        toastr.success('Record has been updated successfully', 'SAVED', {timeOut: 3000});
                        sourcetable.ajax.reload();
                        sourcetable.draw();
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

    $('body').on('click', '.del-source', function () {
        var id = $(this).data('id');
        $('.modal-title').text("DELETE RECORDS");
        $('#del-id').val(id);  
    });  

    $('body').on('click', '#confirm-yes', function () {
        var source = $('#del-id').val();
        $.ajax({
            url: "data/source/" + source,
            type: "DELETE",
            success: function (data) {
                toastr.warning(data.success, 'Deleted', {timeOut: 1000});
                sourcetable.ajax.reload();
                sourcetable.draw();
                $("#delete .close").click();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    })

    $('body').on('click', '.res-source', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });  

    $(document).on('click', '#confirm-res', function () {
        var source = $('#res-id').val();
        $.ajax({
            url: "data/source/" + source,
            type: "POST",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                sourcetable.ajax.reload();
                sourcetable.draw();
                $("#restore .close").click();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    })
});
