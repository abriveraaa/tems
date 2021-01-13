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

    
    // var progress = document.getElementById('animationProgress');
    // var config = {
    //     type: 'line',
    //     data: {
    //         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //         datasets: [{
    //             label: 'My First dataset',
    //             fill: false,
    //             borderColor: window.chartColors.red,
    //             backgroundColor: window.chartColors.red,
    //             data: [
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor()
    //             ]
    //         }, {
    //             label: 'My Second dataset ',
    //             fill: false,
    //             borderColor: window.chartColors.blue,
    //             backgroundColor: window.chartColors.blue,
    //             data: [
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor(),
    //                 randomScalingFactor()
    //             ]
    //         }]
    //     },
    //     options: {
    //         title: {
    //             display: true,
    //             text: 'Chart.js Line Chart - Animation Progress Bar'
    //         },
    //         animation: {
    //             duration: 2000,
    //             onProgress: function(animation) {
    //                 progress.value = animation.currentStep / animation.numSteps;
    //             },
    //             onComplete: function() {
    //                 window.setTimeout(function() {
    //                     progress.value = 0;
    //                 }, 2000);
    //             }
    //         }
    //     }
    // };

    // window.onload = function() {
    //     var ctx = document.getElementById('canvas').getContext('2d');
    //     window.myLine = new Chart(ctx, config);
    // };

    // document.getElementById('randomizeData').addEventListener('click', function() {
    //     config.data.datasets.forEach(function(dataset) {
    //         dataset.data = dataset.data.map(function() {
    //             return randomScalingFactor();
    //         });
    //     });

    //     window.myLine.update();
    // });
});