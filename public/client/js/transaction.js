$(document).ready(function() {
    var lhof = $('#lhoftable').DataTable({
        async: false,
        processing: true,
        serverSide: true,
        pageLength : 5,
        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
        order: [[0, "asc"]],
        ajax: "/category/userlhof",
        columns: [
            { data: "lhof", orderable: true, searchable: true, sortable: true },
            { data: "item_count" },
            { data: "borrower",
                render: function(data){
                    return data[0].studnum;        
                } 
                , orderable: true, searchable: true, sortable: true 
            },
            { data: "borrower",
                render: function(data, type, row){
                    if(data[0].midname == null || data[0].midname == "")
                    {
                        return data[0].lastname +', '+data[0].firstname;
                    }
                    else{
                        return data[0].lastname +', '+data[0].firstname+" "+data[0].midname[0]+".";
                    }                    
                } 
                , orderable: true, searchable: true, sortable: true 
            },
            { data: "room", orderable: true, searchable: true, sortable: true,
                render: function(data){
                    return data[0].code;
                }
            },
            { data: "created_at",
                render: function(data){
                    return moment(data).format("MM/DD/YYYY HH:mm:ss");
                } 
                , orderable: true, searchable: true, sortable: true 
            },
            { data: "action", orderable: false },
        ],
    });

    $(document).on('click', '.print-lhof', function(e){
        var dat = $(this).data("lhof");
        window.location.href = '/report/lhofborrower/' + dat;
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
});
