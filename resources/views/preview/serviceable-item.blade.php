<div class="col-md-12 serviceableitems">
    <div class="invoice p-3 mb-3">
        <div class="serviceableitems">
            <div class="row float-right">
            @permission('report-print')
            <a href="{{ url('/report/serviceableitem') }}" target="_blank" class="btn btn-outline-secondary btn-flat"><i class="fas fa-download"></i> PDF</a>
            @endpermission
            </div>
            <div class="row">
                <div class="col text-center mt-3 mb-3">
                    <h4 clas="text-uppercase font-weight-bold">SERVICEABLE ITEM</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped" id="serviceableitems">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Category</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Property No</th>
                                <th>Source</th>
                                <th>Date Added</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody class="serviceable">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>