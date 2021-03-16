$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#borrowernum').focus();
    $('#room').select2({ width: '100%' });

    $("#borrowernum").keyup(function () {  
        $('#borrowernum').css('text-transform', 'uppercase')
    }); 

    var transaction = $('#transactuser').DataTable({
        
        processing: true,
        serverSide: true,
        order: [[1, "asc"]],
        ajax: '/category/userlhof',
        columns: [
            { data: "lhof" },
            { data: "created_at",
            render: function(d) {
                return moment(d).format("MM/DD/YYYY HH:mm:ss");
                }
            },
            { data: "room",
                render: function(data) {
                    return data[0].code;
                }
            },
            { data: "action" }
        ],
        "rowCallback": function( row, result, index ) {
            var borrowerId = $('#borrId').val();
            if (result.borrower[0].id != borrowerId) {
                $(row).hide();
            }
        },
    });

    $(document).on('click', '.view-lhof', function(e){
        var dat = $(this).data("lhof");
        var itemlhof = $(this).data("id");
        $('.modal-title').html("LHOF NO: "+dat);
        $('#lhofdatatable').DataTable().clear().destroy();
        var lhofdatanum = $('#lhofdatatable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        paging: false,
        info: false,
        searching: false,
        ajax: "/category/itemlhof/" + dat,
            columns: [
            { data: "tool" },
            { data: "item",
                    render: function(data) {
                        return data[0].description;
                    }
                },
            { data: null,
                render: function(data) {
                    var getFirstWord = string => {
                        const words = string.split(' ');
                        return words[0];
                    };
                    var nam = getFirstWord(data.borrow[0].name);
                    return moment(data.created_at).format("MM/DD/YYYY HH:mm:ss") + '  -  ' + nam;
                }
            },
            { data: null,
                render: function(data) {
                    var getFirstWord = string => {
                        const words = string.split(' ');
                        return words[0];
                    };
                    if(data.return.length > 0){
                        var nam = getFirstWord(data.return[0].name);
                        return moment(data.updated_at).format("MM/DD/YYYY HH:mm:ss") + '  -  ' + nam;
                    }else{
                        return '';
                    }
                }
            },
          ]
        });
    });

    $(document).on('click', '.print-lhof', function(e){
        var dat = $(this).data("lhof");
        window.location.href = '/report/lhofborrower/' + dat;
    });

    $('.transaction').hide();

    var authRemove = function(){
        $('.user').remove();
        $('.transaction').hide();
    }

    $('#borrowernum').on('keypress', function(event) {
        var borrowernum = $('#borrowernum').val();
        if(event.which == 13){
            authRemove();
            $.get("/category/borrower/" + borrowernum, function(data) {
                if(data.image == null || data.image == 'null' || data.image == '' || data.image == undefined || data.image == 'undefined'){
                    $('.authenticate').append('<div class="col-auto user pr-3"><div class="small-box user-id"><div class="row p-2"><div class="col d-flex justify-content-left"><img src="img/pup_logo.png" class="school-logo"></div></div><div class="inner row d-flex justify-content-center"><div class="col-auto"><img src="/img/default-photo.png" class="student-photo"><div class="student-profile align-left"><div class="student-profile--firstname mt-1">'+ data.firstname + '</div><div class="student-profile--lastname">'+ data.lastname +'</div><div class="student-profile--idnum">'+ data.studnum +'</div><div class="student-profile--course mt-1">'+ data.borrowercourse[0].description +'<input type="hidden" id="borrId" value="'+ data.id +'"><input type="hidden" id="courseId" value="'+ data.borrowercourse[0].id +'"></div></div></div></div><div class="row"><div class="col d-flex justify-content-center p-2"><button type="button" class="btn btn-sm btn-warning mr-2" id="borrow-item" data-id="'+ data.id +'" data-toggle="modal" data-target="#borrow">Borrow</button><button type="button" class="btn btn-sm btn-success" id="return-item" data-id="'+ data.id +'" data-toggle="modal" data-target="#borrow">Return</button></div></div></div></div>');
                    $('.transaction').show();
                    transaction.ajax.reload();
                }else{
                    $('.authenticate').append('<div class="col-auto user pr-3"><div class="small-box user-id"><div class="row p-2"><div class="col d-flex justify-content-left"><img src="img/pup_logo.png" class="school-logo"></div></div><div class="inner row d-flex justify-content-center"><div class="col-auto"><img src="/img/borrower/'+ data.image +'" class="student-photo"><div class="student-profile align-left"><div class="student-profile--firstname mt-1">'+ data.firstname + '</div><div class="student-profile--lastname">'+ data.lastname +'</div><div class="student-profile--idnum">'+ data.studnum +'</div><div class="student-profile--course mt-1">'+ data.borrowercourse[0].description +'<input type="hidden" id="courseId" value="'+ data.borrowercourse[0].id +'"><input type="hidden" id="borrId" value="'+ data.id +'"></div></div></div></div><div class="row"><div class="col d-flex justify-content-center p-2"><button type="button" class="btn btn-sm btn-warning mr-2" id="borrow-item" data-id="'+ data.id +'" data-toggle="modal" data-target="#borrow">Borrow</button><button type="button" class="btn btn-sm btn-success" id="return-item" data-id="'+ data.id +'" data-toggle="modal" data-target="#borrow">Return</button></div></div></div></div>');
                    $('.transaction').show();
                    transaction.ajax.reload();
                }
                $('#borrowernum').val("");
            })
            .fail(function(data){
                authRemove();
                toastr.error(data.responseJSON.error, 'ERROR', {timeOut: 3000});
                $('.student-photo').attr({src: "/img/default-photo.png"});
                $('#borrowernum').val("");
            });
        }
    });

    $(document).on('click', '#borrow-item', function() { 
        var id = $(this).data("id");
        var crsid = $('#courseId').val();
        $('.modal-title').html('Borrow Item');
        $('.header-hide').show();
        $('.search').hide();
        $('.alt').remove();
        $('#borrownum').blur();
        $('#action').val('Borrow');
        $('#borrower').val(id);
        $('#course').val(crsid);
        $.get("/category/room", function(result){
            if(result)
            {
                $("#room").empty();
                $("#room").append('<option selected value="">Select one</option>');
                $.each(result,function(key,value){
                    $("#room").append('<option value="'+key+'">'+value+'</option>');
                });
            }
        });
        $.get("/category/lastlhof", function(data){
            $('#lhof').val(data);
            $('#lhofhidden').val(data);
        });
        $.get("/category/lhofid", function(data) {
            $('#lhofid').val(data);
        });
    });

    $(document).on('click', '#return-item', function() {
        var id = $(this).data("id");
        $('.modal-title').html("return item");
        $('.search').show();
        $('.search-item').val("");
        $('.alt').remove();
        $('.header-hide').hide();
        $('#action').val("Return");
        $('#borrower').val(id);
      });

    $('#room').on('change', function(e){
        setTimeout(function() {
            $('.select2-container-active').removeClass('select2-container-active');
            $(':focus').blur();
            $('#search-item').focus();
        }, 1);
            $('.search').show();
    });

    $('#search-item').on('keypress', function(e) {
        if(e.which == 13){
            var action = $('#action').val();
            if(action == "Borrow"){ 
                var borrower = $('#idnum').val();
                var item = $('#search-item').val();
                var room = $('#room').val();
                $.get("/category/barcode/" + item, function(data) {
                    var d = new Date();
                    var month = d.getMonth() + 1;
                    var day = d.getDate();
                    var datenow = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    
                    var dt = new Date(Date.now());
                    var hours = dt.getHours();
                    var minutes = dt.getMinutes();
                    var seconds = dt.getSeconds();
                    var timenow = (hours < 10 ? '0' : '') + hours + ":" + (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
                    $('#hiddendesc').val(data.data.toolname[0].id);
                    if(data.status == true){
                        $('.alt').remove();
                        $.ajax({
                            url: "/data/requests",
                            type: "POST",
                            data: $('#request-form').serialize(),
                            dataType: 'json',
                            success: function(data) {
                                transaction.ajax.reload();
                                transaction.draw();
                            },
                            error: function(data) {
            
                            }
                        });
                        $('#search-item').val('');                   
                        $('#search-item').focus();
                        $('#borrowed-item').prepend('<div class="col alt"><div class="d-flex justify-content-between align-items-center border-bottom mb-1 mt-1 pb-2 pt-2"><div class="d-flex flex-column"><span class="item__value align-left"><strong>'+ data.data.barcode +'</strong></span><span class="item__description">'+ data.data.toolname[0].description +'</span></div><div class="d-flex flex-column text-right color-red"><span class="item__value-span">'+ datenow +' '+ timenow +'</span><span class="item__value"> </span></div></div></div>'); 
                        $('#search-item').val('');
                        toastr.success(data.data.toolname[0].description + " borrowed successfully.", 'BORROWED', {timeOut: 3000});   
                        $('#hiddendesc').val("");
                    } 
                })
                .fail(function(data){
                    $('#search-item').val('');                   
                    $('#search-item').focus();
                    toastr.error("Item not Found. Please contact the administrator", 'ITEM NOT FOUND', {timeOut: 5000});   
                    $('#search-item').val('');
                });
                  
            $('#transactuser').DataTable().ajax.reload();    
            }else if(action == "Return"){
                var item = $('#search-item').val();
                var borrower = $('#borrower').val();
                $.get("/category/returnitem/"+item+'/borrower/'+borrower, function(data){
                    var d = new Date();
                    var month = d.getMonth() + 1;
                    var day = d.getDate();
                    var datenow = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
                    var dt = new Date(Date.now());
                    var hours = dt.getHours();
                    var minutes = dt.getMinutes();
                    var seconds = dt.getSeconds();
                    var timenow = (hours < 10 ? '0' : '') + hours + ":" + (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
                    if(data.status == true){
                        toastr.success(data.data[0].item[0].description + " returned successfully.", 'RETURNED', {timeOut: 3000}); 
                        $('#borrowed-item').prepend('<div class="col alt"><div class="d-flex justify-content-between align-items-center border-bottom mb-1 mt-1 pb-2 pt-2"><div class="d-flex flex-column"><span class="item__value align-left"><strong>'+ data.data[0].tool +'</strong></span><span class="item__description">'+ data.data[0].item[0].description +'</span></div><div class="d-flex flex-column text-right color-red"><span class="item__value-span">'+ datenow +' '+ timenow +'</span><span class="item__value"> </span></div></div></div>'); 
                        $('#search-item').val('');
                        transaction.ajax.reload();
                        transaction.draw();
                    }else if(data.banned == true){
                        toastr.success(data.data[0].item[0].description + " returned successfully.", 'RETURNED', {timeOut: 3000});   
                        toastr.warning("Borrower is temporarily banned for borrowing item", 'BANNED USER', {timeOut: 3000});   
                        $('#borrowed-item').prepend('<div class="col alt"><div class="d-flex justify-content-between align-items-center border-bottom mb-1 mt-1 pb-2 pt-2"><div class="d-flex flex-column"><span class="item__value align-left"><strong>'+ data.data[0].tool +'</strong></span><span class="item__description">'+ data.data[0].item[0].description +'</span></div><div class="d-flex flex-column text-right color-red"><span class="item__value-span">'+ datenow +' '+ timenow +'</span><span class="item__value"> </span></div></div></div>'); 
                        transaction.ajax.reload();
                        transaction.draw();
                        $('#search-item').val('');
                    }else{
                        $('#search-item').val('');
                        toastr.error("Item not Found or Item is not in your borrowed list", 'ITEM NOT FOUND', {timeOut: 3000});   
                    }
                });
            }
        }
    });
});