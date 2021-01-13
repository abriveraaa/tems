<div class="col-md-12 banneduser">
    <div class="invoice p-3 mb-3">
        <div class="banneduser">
            <div class="row float-right">
            @permission('report-print')
            <a href="{{ url('/report/bannedborrower') }}" target="_blank" class="btn btn-outline-secondary btn-flat"><i class="fas fa-download"></i> PDF</a>
            @endpermission
            </div>
            <div class="row">
                <div class="col text-center mt-3 mb-3">
                    <h4 clas="text-uppercase font-weight-bold">BANNED USER</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped" id="banneduser">
                        <thead>
                            <tr class="header">
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Course</th>
                                <th>Contact</th>
                            </tr>
                        </thead>
                        <tbody class="banned">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>