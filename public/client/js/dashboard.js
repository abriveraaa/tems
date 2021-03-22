$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let getItemBorrowed = async() => {
        $(".borrow-list").empty();
        const item = await $.get("/category/borroweditem", function(data){});
        item.map((value) => {
            if(value.borrower[0].image == null || value.borrower[0].image == 'null'){
                $(".borrow-list").append('<li class="item"><div class="product-img"><img src="/img/default-photo.png" alt="User Image" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">'+ value.borrower[0].firstname + " " + value.borrower[0].lastname + '<span class="badge badge-warning float-right lhof" data-id="'+ value.lhof +'" data-toggle="modal" data-target="#lhof-data" data-num="'+ value.borrower[0].id +'">'+ value.lhof +'</span></a><span class="product-description">Room: '+ value.room[0].code +'</span></div></li>');
            }else{
                $(".borrow-list").append('<li class="item"><div class="product-img"><img src="/img/borrower/' + value.borrower[0].image +'" alt="User Image" class="img-size-50"></div><div class="product-info"><a href="javascript:void(0)" class="product-title">'+ value.borrower[0].firstname + " " + value.borrower[0].lastname + '<span class="badge badge-warning float-right lhof" data-toggle="modal" data-target="#lhof-data" data-id="'+ value.lhof +'" data-num="'+ value.borrower[0].id +'">'+ value.lhof +'</span></a><span class="product-description">Room: '+ value.room[0].code +'</span></div></li>');
            }
        });
    };

    let getOnHandsItem = async() => {
        $(".product-list").empty();
        const item = await $.get("/category/countcategory", function(data){});
        (item.category).map((value)=> {
            $('.categoryy').append('<div class="card card-success collapsed-card "><div class="card-header"><h3 class="card-title text-uppercase">'+ value.description +'</h3><div class="card-tools"><button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button></div></div><div class="card-body p-0"><ul class="category-'+ value.id +' products-list product-list-in-card pl-2 pr-2"></ul></div></div>'); 
        });

        (item.toolname).map((result)=> {
            if(result.tools_count == 0){
                $(".category-" + result.categories[0].id).append('<li class="item"><div class="product-info ml-0"><span class="product-title text-default">'+ result.description +'<span class="badge badge-danger float-right">Not Available</span></span></div></li>');
            }else{
                $(".category-" + result.categories[0].id).append('<li class="item"><div class="product-info ml-0"><span class="product-title text-default">'+ result.description +'<span class="badge badge-success float-right">Available: '+ result.tools_count +'</span></span></div></li>');
            }
        });
       
    };

    
    let counter = async() => {
        const tools = await $.get("/category/counttools", function(data){});
        $('#toolscount').html(tools);

        const borrowed = await $.get("/category/countborrowed", function(data){});
        $('#toolsborrowed').html(borrowed);

        const onhand = await $.get("/category/countonhand", function(data){});
        $('#toolsonhand').html(onhand);
    };

    let linechartdata = async() => {
        const chartdata = await $.get("/data/dashboard/borrower", function(data){});
        createCompletedJobsChart(chartdata);
    };

    let createCompletedJobsChart = async(chartdata) => {
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
                labels  : chartdata.hours,
                datasets: [{
                type                : 'line',
                data                : chartdata.borrowed_count,
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
                    suggestedMax: chartdata.max
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
    };

    $(document).on('click', '.inventorylist', function(e){
        window.location.href = '/tool';
    });

    $(document).on('click', '.borrower', function(e){
        window.location.href = '/borrower';
    });

    $(document).on('click', '.lhof', function(e){
        var dat = $(this).data("id");
        $('.modal-title').html("LHOF NO: "+dat);
        $('#lhofdatatable').DataTable().clear().destroy();
        $('#lhofdatatable').DataTable({
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

    getItemBorrowed();
    getOnHandsItem();
    counter();
    linechartdata();
});