$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#add-room').click(function() {
        $('#action').val('1');
        $('#room-form').trigger("reset");         
        $('#description').val('');
        $('#code').val('');
        $('#id').val('')
        $('.modal-title').html("Add room");
        $('#save-data').html("Submit");
    });

    var roomtable = $('#room-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[0, "asc"]],
        ajax: 'data/room',
        columns: [
            { data: 'code'},
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

    $('body').on('click', '.edit-room', function () {
        var id = $(this).data('id');
        $('#action').val('2');
        $.get("data/room/" + id, function (data) { 
            $('#room-form').trigger("reset");         
            $('#description').val(data[0].description);
            $('#code').val(data[0].code);
            $('#id').val(data[0].id)
            $('.modal-title').html("Edit room");
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
            var info = $('#room-form').serialize();
            $(this).html("Sending...");
            $.post("data/room", info)
            .done(function(data){
                if (data.success) {
                    $('#room-form').trigger('reset');
                    $('.show').hide();
                    $('#save-data').prop('disabled', false)
                    .html("Submit")
                    .removeClass('uploading');  
                    toastr.success('New record has been saved successfully', 'SAVED', {timeOut: 3000});
                    roomtable.ajax.reload();
                    roomtable.draw();
                }
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
           
            $('#room-form').trigger("reset"); 
        }
        if(action == 2)
        {
            var id = $('#id').val();
            var info = $('#room-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/room/" + id,
                method: "PUT",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#room-form').trigger('reset');
                        $('.show').hide();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                        toastr.success('Record has been updated successfully', 'SAVED', {timeOut: 3000});
                        roomtable.ajax.reload();
                        roomtable.draw();
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

    $('body').on('click', '.del-room', function () {
        var id = $(this).data('id');
        $('.modal-title').text("DELETE RECORDS");
        $('#del-id').val(id);  
    });  

    $('body').on('click', '#confirm-yes', function () {
        var room = $('#del-id').val();
        $.ajax({
            url: "data/room/" + room,
            type: "DELETE",
            success: function (data) {
                toastr.warning(data.success, 'Deleted', {timeOut: 1000});
                roomtable.ajax.reload();
                roomtable.draw();
                $("#delete .close").click();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    })

    $('body').on('click', '.res-room', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });  

    $(document).on('click', '#confirm-res', function () {
        var room = $('#res-id').val();
        $.ajax({
            url: "data/room/" + room,
            type: "POST",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                roomtable.ajax.reload();
                roomtable.draw();
                $("#restore .close").click();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    })
});
