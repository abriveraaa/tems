$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#source').select2({ width: '100%' });
    $('#repreason').select2({ width: '100%' });
    $('#category').select2({ width: '100%' });
    $('#description').select2({ width: '100%' });
    $('#print-tools').hide();

    let load = async() => {
        const toolcategories = await $.get("/category/toolcategories", function(data){});
        $("#category").empty();
        $("#category").append('<option value="" selected disabled>Please choose one</option>');
        $.each(toolcategories,function(key,value){
            $("#category").append('<option value="'+key+'">'+value+'</option>');
        });

        const source = await $.get("/category/source", function(result){});
        $("#source").empty();
        $("#source").append('<option value="" selected disabled>Select one</option>');
        $.each(source,function(key,value){
            $("#source").append('<option value="'+key+'">'+value+'</option>');
        });
    };

    let getToolName = async(id) => {
        const toolname = await $.get("/category/toolname/" + id, function(data){});
        $("#description").empty();
        $("#description").append('<option value="" selected disabled>Select Tool Name</option>');
        $.each(toolname.items,function(key,value){
            $("#description").append('<option value="'+value.id+'">'+value.description+'</option>');
        });

        const lastId = await $.get("/category/lastid/" + id, function(data){});
        $('#barcode').val(lastId);
        $('#category').on('change', function(){
            var id = $(this).val();
            $.get("/category/lastid/" + id, function(data){
                $('#barcode').val(data);
            });
        }); 
    };

    let reportTools = async(id) => {
        const reported = await $.get("data/tools/" + id, function(data) {});
        $('#rep-barcode').val(reported.barcode);
        $('#reptoolId').val(reported.id);
        $('#rep-brand').val(reported.brand);
        (reported.toolcategory).map((value) => {
            $('#rep-category').val(value.description);
            $('#toolcatid').val(value.id);
        });
        (reported.toolname).map((value) => {
            $('#rep-description').val(value.description);
            $('#toolnameid').val(value.id);
        });
    }

    let getBorrower = async(borrower) => {
        try {
            const borrowers = await $.get("category/borrower/" + borrower, function(data) {});
            if(borrowers.midname == null || borrowers.midname == ""){
                $('#rep-name').val(borrowers.firstname + " " + borrowers.lastname);
            }else{
                $('#rep-name').val(borrowers.firstname + " " + borrowers.midname[0] + ". " + borrowers.lastname);
            }
            $('#repnum').val(borrowers.id);
        } catch(error) {
            $('#rep-borrower').val("");
            $('#rep-name').val("");
            $('#repnum').val("");
            $('#rep-borrower').focus();
            toastr.error(error.responseJSON.error, "ERROR", {timeOut: 3000});
        }
    };

    let editTools = async(id) => {
        const editTool = await  $.get("data/tools/"+ id, function(data) {});
        $('#source').val(editTool.toolsource[0].id).trigger('change');  
        $('#brand').val(editTool.brand);
        $('#property').val(editTool.property);
        $('#toolId').val(editTool.id);
        $('#print-tools').val(editTool.id);
        $('#action_btn').val("Edit");
        $('.modal-title').text(editTool.barcode);

        const toolname = await $.get("/category/toolname/" + editTool.toolcategory[0].id, function(results){});
        $('#category').val(toolname.id).trigger('change');

        const tooldesc = await $.get("/category/tooldesc/" + editTool.id, function(res){});
        $('#description').val(tooldesc[0].id).trigger('change');
    }

    $('#category').on('change', function(){
        var id = $(this).val();
        getToolName(id);
    });

    $(document).on('click', '#tools-add', function() {
        $('#tools-form').trigger("reset");
        $('#print-tools').hide();
        $('#description').empty();
        $('.barcodes').show();
        $('#category').val("").trigger('change');
        $('#source').val("").trigger('change');
        $('#action_btn').val("Add");
        $('#save-tools').html("Submit");
        $('.modal-title').text("Add tools");
    });

    $(document).on('click', '#edit-tools', function() {
        var id = $(this).data("id");
        $('#print-tools').show();
        $('.barcodes').hide();
        $('#save-tools').html('<i class="fas fa-save mr-2"></i>Update');
        editTools(id);
    });

    $(document).on('click', '#print-tools', function() {
        var id = $(this).val();
        window.location.href = '/report/barcodeitem/' + id;
    });

    $(document).on('click', '#rep-tools', function(e){
        var id = $(this).data("id");
        $('#report-form').trigger('reset'); 
        $('.modal-title').html("Report Item");
        reportTools(id);
        $('#rep-reason').val("");
        $('#rep-borrower').focus();
    });

    $(document).on('click', '.rep-search', function(event){
        var borrower = $('#rep-borrower').val();
        getBorrower(borrower);
        $('#rep-reason').focus();
    });

    $(document).on('click', '.view-category', function(e){
        var id = $(this).data("id");
        $('#categorymodaltable').DataTable().clear().destroy();
        $('.changing').html("Item Name");
        categorydata = $('#categorymodaltable').DataTable({
            async: false,
            processing: true,
            serverSide: true,
            pageLength : 20,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
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
                { data: "brand", searchable: true },
                { data: "property", searchable: true },
                { data: "toolsource",
                    "render": function ( data, type, row ) {
                        if(data == null || data == ''){
                            return '';
                        }else{
                            return data[0].description;
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
            pageLength : 20,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
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
                { data: "brand", searchable: true },
                { data: "property", searchable: true },
                { data: "toolsource",
                    "render": function ( data, type, row ) {
                        if(data == null || data == ''){
                            return '';
                        }else{
                            return data[0].description;
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
        $.post("data/tools/report" + tools, info)
        .done(function(data){
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
            $('#save-report').prop('disabled', false)
            .html("Report")
            .removeClass('uploading');
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
                    } 
                },
                error: function(data){
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
                    }
                },
                error: function(data){
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
                    $('#save-tools').prop('disabled', false)
                        .html("Submit")
                        .removeClass('uploading');
                }
            });
        }
    });

    var itemname = $('#itemnamelist-table').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        ajax: "/category/sortitemname",
        columns: [
            { data: 'description' },
            { data: 'tools_count' },
            { data: 'action', orderable: false, searchable: false }
        ],
    });

    var report = $('#reportedlist-table').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
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

    var category = $('#categorylisttable').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        ajax: "/category/sortcategory",
        columns: [
            { data: 'description' },
            { data: 'tools_count' },
            { data: 'action', orderable: false, searchable: true }
        ],
    });

    var toolTable = $('#alltools-table').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
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
            { data: "toolsource",
                "render": function ( data, type, row ) {
                    if(data == null || data == ''){
                        return '';
                    }else{
                        return data[0].description;
                    }
                },
                searchable: true,
            },          
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

    load();
});
