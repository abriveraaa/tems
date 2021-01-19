function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#store_image')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var admintable = $('#admin-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        ajax: "data/admin",
        order: [[ 3, 'asc']],
        columns: [
            { data: "name" },
            { data: "email" },
            { data: "position" },
            { data: "deleted_at", visible: false },
            { data: "roles",
                "render": function ( data, type, row ) {
                    return data[0].description;
                }
            },
            { data: "action", name: "action", orderable: false, searchable: false }
        ],
        "createdRow": function( row, data, dataIndex){
            $(row).addClass('deleted');
            if( data.deleted_at !=  null){
                $(row).addClass('bannedClass');
            }
        },
    })

    $.fn.dataTable.ext.errMode = 'throw';

    $('#role').select2({ width: '100%' });
    $('#role').on('change', function() {
        var data = $("#role option:selected").val();
        $("#role_id").val(data);
      });
    

    $("#position").keyup(function () {  
        var txt = $(this).val();
        $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase( );
        }));
    });

    $("#name").keyup(function () {  
        var txt = $(this).val();
        $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase( );
        }));
    });

    $(document).on('click', '#admin-add', function(e){
        $('#admin-form').trigger("reset");
        $('.chance').show();
        $('.email-change').removeClass("col-12");
        $('.role-change').show();
        $.get("category/role", function(data){
            if(data)
            {
                $("#role").empty();
                $("#role").append('<option selected value="" disabled>Please choose one</option>');
                $.each(data,function(key,value){
                    $("#role").append('<option value="'+key+'">'+value+'</option>');
                });
            }
        })
        $('#store_image').attr("src", "/img/default-photo.png");
        $('.modal-title').html("add ADmin");
        $('.action_btn').val("Add");
        $('#save-data').html("Submit");
    });

    $(document).keypress(
    function(event){
        if (event.which == '13') {
        event.preventDefault();
        }
    });

    $('#admin-form').on('submit', function(e){
        e.preventDefault();
        var action = $('.action_btn').val();
        $('#save-data').prop('disabled', true)
        .html("")
        .addClass('uploading');
        if(action == "Add")
        {
            $.ajax({
                url: "data/admin",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'ADMIN ADDED', {timeOut: 3000});
                        admintable.ajax.reload();
                        admintable.draw();
                        $("#add-admin .close").click();
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');                   }
                    if(data.error)
                    {
                        toastr.error(data.error, 'ERROR', {timeOut: 3000});
                        $('#save-data').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');  
                    }
                },
                error: function(jqXHR){
                    toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                    $('#save-data').prop('disabled', false)
                    .html("Submit")
                    .removeClass('uploading');  
                }
            })
        }
        if(action == "Edit")
        {
            var id = $('#id').val();
            $.ajax({
                url: "data/admin/" + id,
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data){
                    if(data.success){
                        toastr.success(data.success, 'ADMIN UPDATED', {timeOut: 3000});
                        admintable.ajax.reload();
                        admintable.draw();
                        $("#add-admin .close").click();
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
                error: function(jqXHR){
                    toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                    $('#save-data').prop('disabled', false)
                    .html("Submit")
                    .removeClass('uploading');  
                }
            })
        }
    });

    $(document).on('click', '#edit-admin', function(e){
        var id = $(this).data("id");
        $('.role-change').hide();
        $('#admin-form').trigger("reset");
        $('.chance').hide();
        $('.email-change').addClass("col-12");
        $('.modal-title').html("Update Admin");
        $('#save-data').html("Update");
        $('.action_btn').val("Edit");
        $.get("data/admin/" + id, function(data){
            if(data.image === null || data.image === "null" || data.image === ""){
                $('#store_image').attr("src", "/img/default-photo.png");
            }else{
                $('#store_image').attr("src", "/img/admin/" + data.image + "");
            }
            $('#store_image').append("<input type='hidden' name='hidden_image' value='"+data.image+"' />");
            $('#name').val(data.name);
            $('#position').val(data.position);
            $('#email').val(data.email);
            $('#id').val(data.id);
        });
    });

    $(document).on('click', '#ban-admin', function(e){
        var id = $(this).data("id");
        $('#del-id').val(id);
        $('#title').html("Confirmation");
        $('#del').html("Are you sure you want to ban this admin?");
        $('#confirm-yes').html("BAN");
    });

    $('#confirm-yes').on('click', function(e){
        var id = $('#del-id').val();

        $.ajax({
            url: "data/admin/"+ id,
            type: "DELETE",
            success: function (data) {
                if(data.success) {
                    admintable.ajax.reload();
                    admintable.draw();
                    $("#delete .close").click();
                    toastr.success(data.success, 'BANNED', {timeOut: 3000});
                }
                if (data.error) {
                    toastr.error(data.error, 'ERROR', {timeOut: 3000});
                }
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    });
    $('body').on('click', '#res-admin', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });  

    $(document).on('click', '#confirm-res', function () {
        var admin = $('#res-id').val();
        $.ajax({
            url: "data/admin/" + admin,
            type: "PUT",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                admintable.ajax.reload();
                admintable.draw();
                $("#restore .close").click();
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    });
});
