<div class="col-md-12 inventory-daily">
    <div class="invoice p-3 mb-3">
        <div class="row float-right">
            <button type="submit" class="btn btn-outline-secondary btn-flat pdf-inventory"><i class="fas fa-download"></i> PDF</button>
            <!-- <a href="{{ url('/report/dailyinventory') }}" target="_blank" class="btn btn-outline-secondary btn-flat"><i class="fas fa-download"></i> PDF</!-->
        </div>
        <div class="row">
            <div class="col text-center mt-3 mb-3">
                <h4 clas="text-uppercase font-weight-bold">TOOLS AND EQUIPMENT INVENTORY CONTROL FORM</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered" id="inventory">
                    <thead>
                        <tr>
                            <th rowspan="3" class="width-100">Quantity As of Prior Inventory</th>
                            <th rowspan="3">Item Description</th>
                            <th rowspan="3">Item Category</th>
                            <th colspan="3">Changes Prior Inventory</th>
                            <th rowspan="3" class="width-100">Current Quantity on Hand</th>
                        </tr>
                        <tr>
                            <th rowspan="2">Quantity Added</th>
                            <th colspan="2">Quantity Deleted</th>
                        </tr>
                        <tr>
                            <th>Lost</th>
                            <th>Damaged</th>
                        </tr>
                    </thead>
                    <tbody class="added">
                    
                    </tbody>
                </table>
            </div>
        </div>  
    </div>
</div>