<div class="col-md-12 reporteditems">
    <div class="invoice p-3 mb-3">
        <div class="reporteditems">
            <div class="row float-right">
            @permission('report-print')
            <a href="{{ url('/report/reporteditem') }}" target="_blank" class="btn btn-outline-secondary btn-flat"><i class="fas fa-download"></i> PDF</a>
            @endpermission
            </div>
            <div class="row">
                <div class="col text-center mt-3 mb-3">
                    <h4 clas="text-uppercase font-weight-bold">REPORTED ITEM</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped" id="reporteditems">
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Reason</th>
                                <th>Date Reported</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody class="reported">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>