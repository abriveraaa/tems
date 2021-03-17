$(document).ready(function(){
    $('#type').select2({
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
    });
    $('#subtype').select2({ width: "100%" });

    $('.inventory-daily').hide();
    $('.itemusage').hide();
    $('.banneduser').hide();
    $('.activeuser').hide();
    $('.reporteditems').hide();
    $('.unserviceableitems').hide();
    $('.serviceableitems').hide();
    $('.type').hide();

    $('.date-range').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    [startDate, endDate] = $('.date-range').val().split(' - ');
    $('#start').val(startDate);
    $('#end').val(endDate);
    
    $(document).on('click', '.applyBtn', function(){
        [startDate, endDate] = $('.date-range').val().split(' - ');
        $('#start').val(startDate);
        $('#end').val(endDate);
        $('.submit').show();
    });

    $(document).on('click', '.pdf-itemusage', function(){
        var startdate = $('#start').val();
        var enddate = $('#end').val();
        window.location.href = '/report/usageitem/start/' + startdate + '/end/' + enddate;     
    });
    
    $(document).on('click', '.pdf-inventory', function(){
        var startdate = $('#start').val();
        var enddate = $('#end').val();
        window.location.href = '/report/inventory/start/' + startdate + '/end/' + enddate;
    });

    $('#type').on('change', function(e){
        var type = $('#type').val();
        if(type == 3){
            $('#title').html("Choose one");
            $('.type').show();
            $('.date').hide();
            var data1 = {
                id: 1,
                text: 'Serviceable Item'
            };
            var data2 = {
                id: 2,
                text: 'Reported Item'
            };
            $("#subtype").empty();
            var sub1 = new Option(data1.text, data1.id, true, true);
            var sub2 = new Option(data2.text, data2.id, true, true);
            $('#subtype').append(sub1).trigger('change');
            $('#subtype').append(sub2).trigger('change');
        }else if(type == 4){
            $('#title').html("Choose one");
            $('.type').show();
            $('.date').hide();
            var data1 = {
                id: 1,
                text: 'Active Borrower'
            };
            var data2 = {
                id: 2,
                text: 'Banned Borrower'
            };
            $("#subtype").empty();
            var sub1 = new Option(data1.text, data1.id, true, true);
            var sub2 = new Option(data2.text, data2.id, true, true);
            $('#subtype').append(sub1).trigger('change');
            $('#subtype').append(sub2).trigger('change');
        }else{
            $('#title').html("Choose a Date");
            $("#subtype").empty();
            $('.type').hide();
            $('.date').show();
        }
    });

    function getFormattedDate(d){
        var todayTime = new Date(d);
        var month = todayTime.getMonth() + 1;
        var day = todayTime.getDate();
        var datenow = todayTime.getFullYear() + '/' + (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day;
        var hour = todayTime.getHours();
        var minute = todayTime.getMinutes();
        var second = todayTime.getSeconds();
        return datenow + ' ' + hour + ':' + minute + ':' + second;
    }

    $('#type').on('change', function(){
        $('.reporteditems').hide();
        $('.itemusage').hide();
        $('.unserviceableitems').hide();
        $('.inventory-daily').hide();
        $('.serviceableitems').hide();
        $('.activeuser').hide();
        $('.banneduser').hide();
        $('.reported').empty();
    })

    $(document).on('click', '.submit', function(){
        var other = $('#subtype').val();
        var category = $('#type').val();
        if(other == '2' && category == '3'){
            $.get("/category/reporteditem", function(data){
                if (data) {
                    $('.reporteditems').show();
                    $('.serviceableitems').hide();
                    $('.activeuser').hide();
                    $('.banneduser').hide();
                    $('.inventory-daily').hide();
                    $('.reported').empty();
                    var getFirstWord = string => {
                        const words = string.split(' ');
                        return words[0];
                    };
                    $.each(data,function(key,value){
                        var admin = getFirstWord(value.tooladmin[0].name);
                        var date = getFormattedDate(value.deleted_at);
                        
                        $('.reported').append('<tr><td>'+value.toolreport[0].studnum+'</td><td>'+value.toolreport[0].firstname + ' ' + value.toolreport[0].lastname +'</td><td>'+value.barcode+'</td><td>'+value.toolname[0].description+'</td><td>'+value.toolcategory[0].description+'</td><td>'+value.reason+'</td><td>'+date+'</td><td>'+admin+'</td></tr>');
                    });
                    
                } else {
                    
                }
            });
        }else if(other == '1' && category == '3'){
            $.get("/category/activeitem", function(data){
                if (data) {
                    $('.reporteditems').hide();
                    $('.activeuser').hide();
                    $('.banneduser').hide();
                    $('.inventory-daily').hide();
                    $('.reported').empty();
                    var getFirstWord = string => {
                        const words = string.split(' ');
                        return words[0];
                    };
                    $('.serviceable').empty();
                    $.each(data,function(key,value){
                        console.log(value)
                        var admin = getFirstWord(value.tooladmin[0].name);
                        var date = getFormattedDate(value.created_at);
                        $('.serviceable').append('<tr><td>'+value.barcode+'</td><td>'+value.toolcategory[0].description+'</td><td>'+value.toolname[0].description+'</td><td>'+value.brand+'</td><td>'+value.property+'</td><td>'+value.toolsource[0].description+'</td><td>'+date+'</td><td>'+admin+'</td></tr>');
                    });
                    $('.serviceableitems').show();
                    
                } else {
                    
                }
            });
        }else if(other == '1' && category == '4'){
            //ACTIVE
            $.get("/category/activeborrower", function(data){
                if (data) {
                    $('.activeuser').show();
                    $('.banneduser').hide();
                    $('.reporteditems').hide();
                    $('.serviceableitems').hide();
                    $('.inventory-daily').hide();
                    $('.useractive').empty();
                    $.each(data,function(key,value){
                        if(value.midname == null || value.midname == ''){
                            $('.useractive').append('<tr><td>'+value.studnum+'</td><td>'+value.lastname+ ', ' +value.firstname+'</td><td>'+value.sex+'</td><td>'+value.borrowercourse[0].code+' '+value.year+'-'+value.section+'</td><td>'+value.contact+'</td></tr>');
                        }else{
                            $('.useractive').append('<tr><td>'+value.studnum+'</td><td>'+value.lastname+ ', ' +value.firstname+ ' ' + value.midname+ '</td><td>'+value.sex+'</td><td>'+value.borrowercourse[0].code+' '+value.year+'-'+value.section+'</td><td>'+value.contact+'</td></tr>');
                        }
                    });
                } else {
                    
                }
            });
        }else if(other == '2' && category == '4'){
            //BANNED
            $.get("/category/bannedborrower", function(data){
                if (data) {
                    $('.activeuser').hide();
                    $('.banneduser').show();
                    $('.reporteditems').hide();
                    $('.inventory-daily').hide();
                    $('.serviceableitems').hide();
                    $('.banned').empty();
                    $.each(data,function(key,value){
                        if(value.midname == null || value.midname == ''){
                            $('.banned').append('<tr><td>'+value.studnum+'</td><td>'+value.lastname+ ', ' +value.firstname+'</td><td>'+value.sex+'</td><td>'+value.borrowercourse[0].code+' '+value.year+'-'+value.section+'</td><td>'+value.contact+'</td></tr>');
                        }else{
                            $('.banned').append('<tr><td>'+value.studnum+'</td><td>'+value.lastname+ ', ' +value.firstname+ ' ' + value.midname+ '</td><td>'+value.sex+'</td><td>'+value.borrowercourse[0].code+' '+value.year+'-'+value.section+'</td><td>'+value.contact+'</td></tr>');
                        }
                    });
                } else {
                    
                }
            });
        }else{
            $('.reporteditems').hide();
            $('.inventory-daily').hide();
            $('.serviceableitems').hide();
            $('.activeuser').hide();
            $('.banneduser').hide();
            $('.reported').empty();
        }
        ////////////////
        if(category == '1'){
            $.ajax({
                url: "/category/inventorycount",
                method: "GET",
                data: $('#date').serialize(),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('.inventory-daily').show();
                        $('.banneduser').hide();
                        $('.activeuser').hide();
                        $('.reporteditems').hide();
                        $('.added').empty();
                        $.each(data,function(key,value){
                            $('.added').append('<tr><td style="text-align:center">'+value.previous+'</td><td>'+value.category+'</td><td>'+value.itemname+'</td><td style="text-align:center">'+value.quantityadded+'</td><td style="text-align:center">'+value.lost_count+'</td><td style="text-align:center">'+value.damaged_count+'</td><td style="text-align:center">'+value.quantityonhand+'</td></tr>');
                        });
                    } else {
                        
                    }
                },
                error: function(data) {
                    
                }
            });
        }else if(category == '2'){
            $.ajax({
                url: "/category/useditem",
                method: "GET",
                data: $('#date').serialize(),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        $('.itemusage').show();
                        $('.banneduser').hide();
                        $('.activeuser').hide();
                        $('.reporteditems').hide();
                        $('.inventory-daily').hide();
                        $('.counted').empty();
                        $.each(data,function(key,value){
                            $('.counted').append('<tr><td>'+value.description+'</td><td>'+value.count+'</td></tr>');
                        });
                        
                    } else {
                        
                    }
                },
                error: function(data) {
                    
                }
            });
        }else if(category == '3'){
            //
        }else if(category == '4'){
            //
        }else{
            
        }
        
    });
});
