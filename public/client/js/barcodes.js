$(document).ready(function(){
    $('#category').select2({ width: '100%' });
    $('#choices').select2({ width: '100%' });
    $('.barnum').hide();

    $(document).on('click', '.print-view',function(e){
        window.print();
    });

    // $(document).on('click', '.generate-barcode',function(e){
    //     var barcode = $('#barcodenum').val();
    //     var settings = {
    //         barWidth: 1,
    //         barHeight: 30,
    //         fontSize: 12,
    //         moduleSize: 5,

    //     };
    //     $.get("{{ url('api/barcode') }}", function(data){
    //         var bar = $('.sam').barcode(barcode, "code39", settings);
    //     })
    // });
    
    // $('#choices').on('change', function(){   
    //     var choice = $(this).val();
    //     if(choice == 1){
    //         $.get("{{ route('getcategory') }}", function(res){
    //             if(res)
    //             {
    //                 $('.barnum').hide();
    //                 $('.category').show();
    //                 $("#category").empty();
    //                 $("#category").append('<option selected value="">Please choose one</option>');
    //                 $.each(res,function(key,value){
    //                     $("#category").append('<option value="'+key+'">'+value+'</option>');
    //                 });
                    
    //             }
    //         });
    //     } else if(choice == 2) {
    //         $.get("{{ url('getItemName') }}", function(res){
    //             if(res)
    //             {
    //                 if(res)
    //                 {
    //                     $("#category").empty();
    //                     $("#category").append('<option value="">Select Item Name</option>');
    //                     $.each(res,function(key,value){
    //                         $("#category").append('<option value="'+key+'">'+value+'</option>');
    //                     });
    //                 }
    //             }
    //         });
    //     }else if(choice == 4) {
    //         $('.barnum').show();
    //         $('.category').hide();
    //     }else {
    //         $('.barnum').hide();
    //         $('.category').show();
    //         $("#category").empty();
    //     }
    // })

    // $('#category').on('change', function(){
    // });
});