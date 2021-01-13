<div class="col-md-12 itemusage">
    <div class="invoice p-3 mb-3">
        <div class="itemusage">
            <div class="row float-right">
            @permission('report-print')
            <button type="submit" class="btn btn-outline-secondary btn-flat pdf-itemusage"><i class="fas fa-download"></i> PDF</button>
            @endpermission
            </div>
            <div class="row">
                <div class="col text-center mt-3 mb-3">
                    <h4 clas="text-uppercase font-weight-bold">TOOLS AND EQUIPMENT USAGE REPORT</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped" id="itemusage">
                        <thead>
                            <tr>
                                <th>Item Description</th>
                                <th>No of Used</th>
                            </tr>
                        </thead>
                        <tbody class="counted">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>