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

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let loadCollege = async() => {
        $('#college').empty();
        const colleges = await $.get("/category/college", function(data){})
    
        $("#college").append('<option value="" selected disabled>Select College</option>');
        $.each(colleges,function(key,value){
            $("#college").append('<option value="'+key+'">'+value+'</option>');
        });
    };

    let loadCourse = async(id) => {
        $("#course").empty();
        const course = await $.get("/category/course/" + id, function(data){});
        $("#course").append('<option value="" selected disabled>Select Course</option>');
        (course.courses).map((value) => {
            $("#course").append('<option value="'+value.id+'">'+value.description+'</option>');
        });
    }

    let getCollege = async(id) => {
        const colleges = await $.get("/category/collegeuser/" + id, function(data){});
        colleges.map((value) => {
            $('#college').val(value.id).trigger('change'); 
        });

        const course = await $.get("/category/courseuser/" + id, function(data){});
        course.map((value) => {
            $('#course').val(value.id).trigger('change'); 
        });
    };

    loadCollege();

    $('#college').on('change', function(){
        var id = $(this).val();
        loadCourse(id);
    });

    let getBorrower = async(id) => {
        const borrower = await $.get("data/borrower/" + id, function(data){});

        if(borrower.image === null || borrower.image === "null" || borrower.image === ""){
            $('#store_image').attr("src", "/img/default-photo.png");
        }else{
            $('#store_image').attr("src", "/img/borrower/" + borrower.image + "");
        }
        getCollege(borrower.id);
        $('#store_image').append("<div id='hide-img'><input type='hidden' name='hidden_image' value='"+ borrower.image +"' /></div>");
        $('#studnum').val(borrower.studnum);
        $('#contact').val(borrower.contact);
        $('#sex').val(borrower.sex).trigger("change");
        $('#firstname').val(borrower.firstname);
        $('#midname').val(borrower.midname);
        $('#lastname').val(borrower.lastname);
        $('#year').val(borrower.year);
        $('#section').val(borrower.section);
        $('#borrower_id').val(borrower.id);
    };

    var borrowertable = $('#borrower-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[1, "asc"]],
        ajax: 'data/borrower',
        columns: [
            { data: 'studnum'},
            { data: 'firstname'},
            { data: 'midname'},
            { data: 'lastname'},
            { data: 'sex'},
            { data: "borrowercourse" },
            { data: 'year'},
            { data: 'section'},
            { data: 'contact'},
            { data: "deleted_at", visible: false },
            { data: 'action', "hideIfEmpty": true ,orderable: false, searchable: false},
        ],
        "createdRow": function( row, data, dataIndex){
            $(row).addClass('deleted');
            if( data.reported_at !=  null){
                $(row).addClass('bannedClass');
            }
            
        },
        "columnDefs": [
            {
                "data": null,
                "render": function ( res, type, row ) {
                    if(row.midname == null || row.midname == "")
                    {
                        return row.lastname +', '+row.firstname;
                    }
                    else {
                        return row.lastname +', '+row.firstname+" "+row.midname[0]+".";
                    }
                },
                "targets": 1,
            },
            {
                "data": "borrowercourse",
                "render": function ( data, type, row ) {
                    if(data == ''){
                        return '';
                    }else{
                        
                        return data[0].code +' '+row.year+"-"+row.section;
                    }
                },
                "targets": 5,
            },
            { "visible": false,  "targets": [ 2 ] },
            { "visible": false,  "targets": [ 3 ] },
            { "visible": false,  "targets": [ 6 ] },
            { "visible": false,  "targets": [ 7 ] },
        ]
    });

   $('table').each(function(a, tbl) {
    var currentTableRows = $(this).find("tr").length - 1;
    $(tbl).find('th').each(function(i) {
        var removeVal = 0;
        var currentTable = $(this).parents('table');

        var tds = currentTable.find('tr td:nth-child(' + (i + 1) + ')');
        tds.each(function(j) { if ($(this).text().trim() == '') removeVal++; });
        
        if (removeVal == currentTableRows) {
            $(this).hide();
            tds.hide();
        }
    });
});

    $("#studnum").keyup(function () {  
        $('#studnum').css('text-transform', 'uppercase')
    });  

    $("#firstname").keyup(function () {  
        var txt = $(this).val();
        $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase( );
        }));
    });  

    $("#midname").keyup(function () { 
        var txt = $(this).val();
        $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase( );
        }));
    }); 

    $("#lastname").keyup(function () { 
        var txt = $(this).val();
        $(this).val(txt.replace(/^(.)|\s(.)/g, function ($1) {
        return $1.toUpperCase( );
        }));
    }); 
    
    $('#sex').select2({ width: '100%' });
    $('#college').select2({ width: '100%' });
    $('#course').select2({ width: '100%' });

    $(document).on('click', '#borrower-add', function() {
        $('#borrower-form').trigger("reset");         
        $('#college').val("").trigger("change");
        $('#hide-img').remove();
        $('#action-borrower').val('Add');
        $('#sex').select2({ width: '100%' });
        $('#store_image').attr("src", "/img/default-photo.png");
        $('.modal-title').html("Add Borrower");
        $('#save-data').text("Save Changes");
    });

    $(document).on('click', '#edit-borrower', function(e){
        var id = $(this).data("id");
        $('#borrower-form').trigger("reset");
        $('#course').val("").trigger("change");
        $('.chance').hide();
        $('.modal-title').html("Update borrower");
        $('#save-data').html("Update");
        $('#action-borrower').val("Edit");
        getBorrower(id);
    });

    $('#borrower-form').on('submit', function(e){
        e.preventDefault();
        var action = $('#action-borrower').val();
        $('#save-data').prop('disabled', true)
        .html("")
        .addClass('uploading');
        if(action == "Add")
        {
            $.ajax({
                url: "data/borrower",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data){
                    if(data){
                        toastr.success(data.success, 'ADDED', {timeOut: 1000});
                        borrowertable.ajax.reload();
                        borrowertable.draw();
                        $("#add-borrower .close").click();
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
        if(action == "Edit")
        {
            var id = $('#id').val();
            $.ajax({
                url: "data/borrower/" + id,
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data){
                    if(data){
                        toastr.success(data.success, 'UPDATED', {timeOut: 1000});
                        borrowertable.ajax.reload();
                        borrowertable.draw();
                        $("#add-borrower .close").click();
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

    $(document).on('click', '#ban-borrower', function(e){
        var id = $(this).data("id");
        $('#del-id').val(id);
        $('#title').html("Confirmation");
        $('#del').html("Are you sure you want to ban this borrower?");
        $('#confirm-yes').html("BAN");
    });

    $('#confirm-yes').on('click', function(e){
        var id = $('#del-id').val();

        $.ajax({
            url: "data/borrower/"+ id,
            type: "DELETE",
            success: function (data) {
                if(data.success) {
                    borrowertable.ajax.reload();
                    borrowertable.draw();
                    $("#delete .close").click();
                    toastr.success(data.success, 'BANNED', {timeOut: 1000});
                }
                if (data.error) {
                    toastr.error(data.error, 'ERROR', {timeOut: 1000});
                }
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    });

    $('body').on('click', '#res-borrower', function () {
        var id = $(this).data('id');
        $('.modal-title').text("RESTORE RECORDS");
        $('#res-id').val(id);  
    });  

    $(document).on('click', '#confirm-res', function () {
        var borrower = $('#res-id').val();
        $.ajax({
            url: "data/borrower/" + borrower,
            type: "PUT",
            success: function (data) {
                toastr.success(data.success, 'Restored', {timeOut: 1000});
                borrowertable.ajax.reload();
                borrowertable.draw();
                $("#restore .close").click();
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-data').html('Submit');
            }
        });
    });
});