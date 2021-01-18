<div class="modal fade" id="report">
    <div class="modal-dialog modal-default">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form name="report-form" class="mb-0" id="report-form" onkeydown="return event.key != 'Enter';">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="rep-barcode" class="form__label">Barcode</label>
                            <input type="text" name="repBarcode" id="rep-barcode" class="form-control color-red" value="" readonly="">
                            <input type="hidden" name="reptoolId" id="reptoolId">
                        </div>
                            <div class="col">
                            <label for="rep-category" class="form__label">Tool Category</label>
                            <input type="text" name="rep-category" id="rep-category" class="form-control color-red" value="" readonly="">
                            <input type="hidden" name="toolcatid" id="toolcatid">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="rep-description" class="form__label">Tool Name</label>
                                <input type="text" name="rep-description" id="rep-description" class="form-control color-red" value="" readonly="">
                                <input type="hidden" name="toolnameid" id="toolnameid">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="rep-brand" class="form__label">Brand</label>
                                <input type="text" name="rep-brand" id="rep-brand" class="form-control color-red" value="" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="rep-borrower" class="form__label">Borrower</label>
                                <input type="text" name="rep-borrower" id="rep-borrower" class="form-control color-red" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-group mt-4 pt-2">
                                <button type="button" class="btn btn-warning rep-search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="rep-name" class="form__label">Name</label>
                                <input type="text" name="rep-name" id="rep-name" class="form-control color-red" value="" readonly>
                                <input type="hidden" name="repnum" id="repnum">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="repreason" class="form__label">Reason</label>
                                <select class="form__input" name="repreason" id="repreason">
                                    <option value="" selected disabled>Choose One</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Damaged">Damaged</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-primary text-uppercase" id="save-report">REPORT</button>
                    </div>
                </div>
            </div>
                </form>
        </div>
    </div>
</div>
