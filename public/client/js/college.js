$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add-college').click(function() {
        $('#action').val('1');
        $('#college-form').trigger("reset");         
        $('#description').val('');
        $('#code').val('');
        $('#id').val('')
        $('.modal-title').html("Add College");
        $('#save-data').text("Submit");
    });

    var collegetable = $('#college-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[1, "asc"]],
        ajax: 'data/college',
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

    $('body').on('click', '.edit-college', function () {
        var id = $(this).data('id');
        $('#action').val('2');
        $.get("data/college/" + id, function (data) { 
            $('#college-form').trigger("reset");         
            $('#description').val(data[0].description);
            $('#code').val(data[0].code);
            $('#id').val(data[0].id)
            $('.modal-title').html("Edit College");
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
            var info = $('#college-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/college",
                method: "POST",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#college-form').trigger('reset');
                        $('.show').hide();
                        toastr.success('New record has been saved successfully', 'SAVED', {timeOut: 3000});
                        collegetable.ajax.reload();
                        collegetable.draw();
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
            $('#college-form').trigger("reset"); 
        }
        if(action == 2)
        {
            var id = $('#id').val();
            var info = $('#college-form').serialize();
            $(this).html("Sending...");
            $.ajax({
                url: "data/college/" + id,
                method: "PUT",
                data: info,
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('#college-form').trigger('reset');
                        $('.show').hide();
                        toastr.success('Record has been updated successfully', 'SAVED', {timeOut: 3000});
                        collegetable.ajax.reload();
                        collegetable.draw();
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
        }
    })

    $('body').on('click', '.del-college', function () {
        var id = $(this).data('id');
        $('.modal-title').text("DELETE RECORDS");
        $('#del-id').val(id);  
    });  

    $('body').on('click', '#confirm-yes', function () {
        var college = $('#del-id').val();
        $.ajax({
            url: "data/college/" + college,
            type: "DELETE",
            success: function (data) {
                toastr.warning(data.success, 'Deleted', {timeOut: 1000});
                collegetable.ajax.reload();
                collegetable.draw();
                $("#delete .close").click();
            },
            error: function(data) {
                toastr.error(data.responseJSON.message, "ERROR", {timeOut: 3000});
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');
            }
        });
    })

    $('body').on('click', '.res-college', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });  

    $(document).on('click', '#confirm-res', function () {
        var college = $('#res-id').val();
        $.ajax({
            url: "data/college/" + college,
            type: "POST",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                collegetable.ajax.reload();
                collegetable.draw();
                $("#restore .close").click();
            },
            error: function(data) {
                toastr.error(data.responseJSON.message, "ERROR", {timeOut: 3000});
                $('#save-data').prop('disabled', false)
                .html("Submit")
                .removeClass('uploading');
            }
        });
    })
});
