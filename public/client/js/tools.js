$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#room').select2({ width: '100%' });
    $('#repreason').select2({ width: '100%' });
    $('#category').select2({ width: '100%' });
    $('#description').select2({ width: '100%' });
    $('#print-tools').hide();

    var load = function(){
        $.get("/category/toolcategories", function(res){
            if(res)
            {
                $("#category").empty();
                $("#category").append('<option value="" selected disabled>Please choose one</option>');
                $.each(res,function(key,value){
                    $("#category").append('<option value="'+key+'">'+value+'</option>');
                });
            }
        });
        
        $.get("/category/room", function(result){
            if(result)
            {
                $("#room").empty();
                $("#room").append('<option value="" selected disabled>Select one</option>');
                $.each(result,function(key,value){
                    $("#room").append('<option value="'+key+'">'+value+'</option>');
                });
            }
        });
        $('#category').on('change', function(){
            var id = $(this).val();
            $.get("/category/toolname/" + id, function(data){
                if(data)
                {
                    $("#description").empty();
                    $("#description").append('<option value="" selected disabled>Select Tool Name</option>');
                    $.each(data.items,function(key,value){
                        $("#description").append('<option value="'+value.id+'">'+value.description+'</option>');
                    });
                }
            });
        });
    }

    

    var toolTable = $('#alltools-table').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        order: [[6, "desc"]],
        ajax: "/data/tools",
        columns: [
            { data: 'barcode', name: 'barcode' },
            { data: 'toolname',
                "render": function ( data, type, row ) {
                    if(data == null || data == ''){
                        return '';
                    }else{
                        return data[0].description;
                    }
                },
                searchable: true,
            },
            { data: 'property' },             
            { data: 'created_at',
                render: function(d) {
                    return moment(d).format("MM/DD/YYYY HH:mm:ss");
                }
            },
            { data: 'tooladmin',
                "render": function (data) {
                    var getFirstWord = string => {
                        const words = string.split(' ');
                        return words[0];
                    };
                    if(data == null || data == ''){
                        return '';
                    }else{
                        var nam = getFirstWord(data[0].name);
                        return nam;
                    }
                },
            },             
            { data: 'brand', visible: false },
            { data: 'deleted_at', visible: false },
            { data: 'updated_at', visible: false },
            { data: 'action', name: 'action', searchable: false, orderable: false }
        ],
        "createdRow": function(row, data, dataIndex){
            $(row).addClass('deleted');
            if(data.deleted_at != null){
                $(row).addClass('bannedClass');
            }else if(data.reason == 'Borrowed'){
                $(row).addClass('borrowedClass');
            }
        },
        "rowCallback": function( row, data, index ) {
            if (data.toolname.length == 0) {
                $(row).hide();
            }
        },
    });

    var category = $('#categorylisttable').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        ajax: "/category/sortcategory",
        columns: [
            { data: 'description' },
            { data: 'tools_count' },
            { data: 'action', orderable: false, searchable: true }
        ],
    });

    var report = $('#reportedlist-table').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        ajax: "/category/reported",
        columns: [
            { data: 'toolreport',
                render: function(data) {
                    return data[0].studnum;
                }
            },
            { data: 'toolreport',
                render: function(data) {
                    if(data[0].midname == null || data[0].midname == ""){
                        return data[0].lastname + ", " + data[0].firstname;
                    }else{
                        return data[0].lastname + ", " + data[0].firstname + " " + data[0].midname[0];
                    }
                }
            },
            { data: 'barcode', },
            { data: 'toolname',
                render: function(data) {
                    return data[0].description;
                }
            },
            { data: 'brand', },
            { data: 'reason' },
            { data: 'deleted_at',
                render: function(d) {
                    return moment(d).format("MM/DD/YYYY HH:mm:ss");
                }
            },
            { data: 'tooladmin',
                "render": function (data) {
                    var getFirstWord = string => {
                        const words = string.split(' ');
                        return words[0];
                    };
                    if(data == null || data == ''){
                        return '';
                    }else{
                        var nam = getFirstWord(data[0].name);
                        return nam;
                    }
                },
            },
        ],
    });

    var itemname = $('#itemnamelist-table').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        ajax: "/category/sortitemname",
        columns: [
            { data: 'description' },
            { data: 'tools_count' },
            { data: 'action', orderable: false, searchable: false }
        ],
    });

    load();

    $(document).on('click', '#tools-add', function() {
        $('#tools-form').trigger("reset");
        $('#print-tools').hide();
        $('#description').empty();
        $('.barcodes').show();
        $('#category').val("").trigger('change');
        $('#room').val("").trigger('change');
        $('#action_btn').val("Add");
        $('#save-tools').html("Submit");
        $('.modal-title').text("Add tools");
        $('#category').on('change', function(){
            var id = $(this).val();
            $.get("/category/lastid/" + id, function(data){
                $('#barcode').val(data);
            });
        });
    });

    $(document).on('click', '#edit-tools', function() {
        var id = $(this).data("id");
        $('#print-tools').show();
        $('.barcodes').hide();
        $('#save-tools').html('<i class="fas fa-save mr-2"></i>Update');
        $.get("data/tools/"+ id, function(data) {
            $.get("/category/toolname/" + data.toolcategory[0].id, function(results){
                $('#category').val(results.id).trigger('change');
                $.get("/category/tooldesc/" + data.id, function(res){
                    $('#description').val(res[0].id).trigger('change');
                });
            });
            $('#room').val(data.toolroom[0].id).trigger('change');  
            $('#brand').val(data.brand);
            $('#property').val(data.property);
            $('#toolId').val(data.id);
            $('#print-tools').val(data.id);
            $('#action_btn').val("Edit");
            $('.modal-title').text(data.barcode);
        })
    });

    $(document).on('click', '#print-tools', function() {
        var id = $(this).val();
        window.location.href = '/report/barcodeitem/' + id;
    });

    $(document).on('click', '#rep-tools', function(e){
        var id = $(this).data("id");
        $('#report-form').trigger('reset'); 
        $('.modal-title').html("Report Item");
        $.get("data/tools/" + id, function(data) {
            $('#rep-barcode').val(data.barcode);
            $('#reptoolId').val(data.id);
            $('#rep-category').val(data.toolcategory[0].description);
            $('#toolcatid').val(data.toolcategory[0].id);
            $('#rep-description').val(data.toolname[0].description);
            $('#toolnameid').val(data.toolname[0].id);
            $('#rep-brand').val(data.brand);
            $('#rep-reason').val("");
            $('#rep-borrower').focus();
        });
    });

    $(document).on('click', '.rep-search', function(event){
        var borrower = $('#rep-borrower').val();
        $.get("category/borrower/" + borrower, function(data) {
            if(data.midname == null || data.midname == ""){
                $('#rep-name').val(data.firstname + " " + data.lastname);
            }else{
                $('#rep-name').val(data.firstname + " " + data.midname[0] + ". " + data.lastname);
            }
            $('#repnum').val(data.id);
            $('#rep-reason').focus();
        })
        .fail(function(data) {
            $('#rep-borrower').val("");
            $('#rep-name').val("");
            $('#repnum').val("");
            $('#rep-borrower').focus();
            toastr.error(data.responseJSON.error, "ERROR", {timeOut: 3000});
        });
    });



    $(document).on('click', '.view-category', function(e){
        var id = $(this).data("id");
        $('#categorymodaltable').DataTable().clear().destroy();
        $('.changing').html("Item Name");
        categorydata = $('#categorymodaltable').DataTable({
            async: false,
            processing: true,
            serverSide: true,
            ajax: "/category/toolcategory/" + id,
            columns: [
                { data: "barcode" },
                { data: "toolcategory",
                    "render": function (data, type, row) {
                        return data[0].pivot.category_id;
                    },   
                    visible: false 
                },
                { data: "toolname",
                    "render": function ( data, type, row ) {
                        if(data == null || data == ''){
                            return '';
                        }else{
                            return data[0].description;
                        }
                    },
                    searchable: true,
                },
                { data: "brand" },
                { data: "property" },
                { data: "toolroom",
                    "render": function ( data, type, row ) {
                        if(data == null || data == ''){
                            return '';
                        }else{
                            return data[0].code;
                        }
                    },
                    searchable: true,
                },
                { data: "created_at",
                    render: function(d) {
                        return moment(d).format("MM/DD/YYYY HH:mm:ss");
                    }
                },
                { data: 'tooladmin',
                    "render": function (data) {
                        var getFirstWord = string => {
                            const words = string.split(' ');
                            return words[0];
                        };
                        if(data == null || data == ''){
                            return '';
                        }else{
                            var nam = getFirstWord(data[0].name);
                            return nam;
                        }
                    },
                },
            ],
            "rowCallback": function( row, result, index ) {
                if (result.toolcategory[0].pivot.category_id != id) {
                    $(row).hide();
                }
            },
        });
    });
    
    $(document).on('click', '.view-itemname', function(e){
        var id = $(this).data("id");
        $('#categorymodaltable').DataTable().clear().destroy();
        // $('.modal-title').html(data.data[0].description);
        $('.changing').html("Item Name");
        categorydata = $('#categorymodaltable').DataTable({
            async: false,
            processing: true,
            serverSide: true,
            ajax: "/category/toolcategory/" + id,
            columns: [
                { data: "barcode" },
                { data: "toolname",
                    "render": function (data, type, row) {
                        return data[0].pivot.tool_name_id;
                    },   
                    visible: false 
                },
                { data: "toolname",
                    "render": function ( data, type, row ) {
                        if(data == null || data == ''){
                            return '';
                        }else{
                            return data[0].description;
                        }
                    },
                    searchable: true,
                },
                { data: "brand" },
                { data: "property" },
                { data: "toolroom",
                    "render": function ( data, type, row ) {
                        if(data == null || data == ''){
                            return '';
                        }else{
                            return data[0].code;
                        }
                    },
                    searchable: true,
                },
                { data: "created_at",
                    render: function(d) {
                        return moment(d).format("MM/DD/YYYY HH:mm:ss");
                    }
                },
                { data: 'tooladmin',
                    "render": function (data) {
                        var getFirstWord = string => {
                            const words = string.split(' ');
                            return words[0];
                        };
                        if(data == null || data == ''){
                            return '';
                        }else{
                            var nam = getFirstWord(data[0].name);
                            return nam;
                        }
                    },
                },
            ],
            "rowCallback": function( row, result, index ) {
                if (result.toolname[0].pivot.tool_name_id != id) {
                    $(row).hide();
                }
            },
        });
    });

    $(document).on('click', '#save-report', function(event) {
        event.preventDefault();
        var tools = $('#repnum').val();
        var info = $('#report-form').serialize();
        $('#save-report').prop('disabled', true)
        .html("")
        .addClass('uploading');
        $.ajax({
            url: "data/tools/report/" + tools,
            method: "POST",
            data: info,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $('#report-form').trigger('reset');
                    itemname.ajax.reload();
                    itemname.draw();
                    toolTable.ajax.reload();
                    toolTable.draw();
                    category.ajax.reload();
                    category.draw();
                    report.ajax.reload();
                    report.draw();
                    $('#report .close').click();
                    toastr.success('Item reported succesfully!', 'ADDED', {timeOut: 3000});
                    $('#save-report').prop('disabled', false)
                    .html("Report")
                    .removeClass('uploading');
                } else {
                    toastr.error(data.error, 'ERROR', {timeOut: 3000});
                    $('#save-report').prop('disabled', false)
                    .html("Report")
                    .removeClass('uploading');
                }
            },
            error: function(jqXHR) {
                toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                $('#save-report').prop('disabled', false)
                .html("Report")
                .removeClass('uploading');
            }
        });
    });

    $('#tools-form').on('submit', function(event) {
        event.preventDefault();
        var action = $('#action_btn').val();
        var tools = $('#toolId').val();
        $('#save-tools').prop('disabled', true)
        .html("")
        .addClass('uploading');
        if (action == "Add") {
            $.ajax({
                url: "data/tools",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#tools-form').trigger('reset');
                        itemname.ajax.reload();
                        itemname.draw();
                        toolTable.ajax.reload();
                        toolTable.draw();
                        category.ajax.reload();
                        category.draw();
                        report.ajax.reload();
                        report.draw();
                        $('#add-tools .close').click()
                        $('#save-tools').prop('disabled', false)
                        .html("")
                        .removeClass('uploading');
                        toastr.success('Item added succesfully!', 'ADDED', {timeOut: 5000});
                    } else {
                        toastr.error(data.error, 'ERROR', {timeOut: 5000});
                         $('#save-tools').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');
                        }
                    },
                    error: function(jqXHR){
                        toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                        $('#save-tools').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');
                    }
            });
        }
        if (action == "Edit") {
            $.ajax({
                url: "data/tools/" + tools,
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        itemname.ajax.reload();
                        itemname.draw();
                        toolTable.ajax.reload();
                        toolTable.draw();
                        category.ajax.reload();
                        category.draw();
                        report.ajax.reload();
                        report.draw();
                        $('#add-tools .close').click();
                        toastr.success('Item updated succesfully!', 'UPDATED', {timeOut: 3000});
                        $('#save-tools').prop('disabled', false)
                        .html("")
                        .removeClass('uploading');
                    } else {
                        toastr.error(data.error, 'ERROR', {timeOut: 5000});
                         $('#save-tools').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');
                    }
                },
                error: function(jqXHR){
                    toastr.error(jqXHR.responseJSON.message, jqXHR.statusText, {timeOut: 3000});
                    $('#save-tools').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');
                }
            });
        }
    });
});
