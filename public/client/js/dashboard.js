$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.get("/category/borroweditem", function(result){   
        $(".borrow-list").empty();
        $.each(result,function(key,value){
            if(value.borrower[0].image == null){
                $(".borrow-list").append('<li class="item"><div class="product-img"><img src="/img/default-photo.png" alt="User Image" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">'+ value.borrower[0].firstname + " " + value.borrower[0].lastname + '<span class="badge badge-success float-right lhof" data-id="'+ value.lhof +'" data-num="'+ value.borrower[0].id +'">'+ value.lhof +'</span></a><span class="product-description">Room: '+ value.room[0].code +'</span></div></li>');
            }else{
                $(".borrow-list").append('<li class="item"><div class="product-img"><img src="/img/borrower/' + value.borrower[0].image +'" alt="User Image" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">'+ value.borrower[0].firstname + " " + value.borrower[0].lastname + '<span class="badge badge-success float-right lhof" data-id="'+ value.lhof +'" data-num="'+ value.borrower[0].id +'">'+ value.lhof +'</span></a><span class="product-description">Room: '+ value.room[0].code +'</span></div></li>');
            }
        });
    });

    var active = $.get("/category/countactive", function(data){
        $('#activecount').html(data);
    })
    .done(function() {
        active;
    })
    .fail(function() {
        active;
    })
    .always(function() {
        active;
    });


    var banned = $.get("/category/countbanned", function(data){
        $('#bannedcount').html(data);
    })
    .done(function() {
        banned;
    })
    .fail(function() {
        banned;
    })
    .always(function() {
        banned;
    });


    var tools = $.get("/category/counttools", function(data){
        $('#toolscount').html(data);
    })
    .done(function() {
        tools;
    })
    .fail(function() {
        tools;
    })
    .always(function() {
        tools;
    });


    var newcount = $.get("/category/countnew", function(data){
        $('#newcount').html(data);
    })
    .done(function() {
        newcount;
    })
    .fail(function() {
        newcount;
    })
    .always(function() {
        newcount;
    });



    var linechartdata = $.get("/data/dashboard/borrower", function(response){

    })
    .done(function(response){
        createCompletedJobsChart(response);
    });

    function createCompletedJobsChart(response){
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode      = 'index'
        var intersect = true

        var $visitorsChart = $('#visitors-chart')
        var visitorsChart  = new Chart($visitorsChart, {
            linechartdata,
            data   : {
                labels  : response.hours,
                datasets: [{
                type                : 'line',
                data                : response.borrowed_count,
                backgroundColor     : 'transparent',
                borderColor         : '#007bff',
                pointBorderColor    : '#007bff',
                pointBackgroundColor: '#007bff',
                fill                : true,
                pointHoverBackgroundColor: '#007bff',
                pointHoverBorderColor    : '#007bff'
                },
                ]
            },
            options: {
                maintainAspectRatio: true,
                tooltips           : {
                mode     : mode,
                intersect: intersect
                },
                hover              : {
                mode     : mode,
                intersect: intersect
                },
                legend             : {
                display: false
                },
                scales             : {
                yAxes: [{
                    display: true,
                    gridLines: {
                    display      : false,
                    lineWidth    : '4px',
                    color        : 'rgba(0, 0, 0, .2)',
                    zeroLineColor: 'transparent'
                    },
                    ticks    : $.extend({
                    beginAtZero : true,
                    suggestedMax: response.max
                    }, ticksStyle)
                }],
                xAxes: [{
                    display  : true,
                    gridLines: {
                    display: false
                    },
                    ticks    : ticksStyle
                }]
                }
            }
        });
    }
});
