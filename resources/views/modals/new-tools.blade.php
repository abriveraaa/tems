<div class="modal fade" id="add-tools">
  <div class="modal-dialog width-tools">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-uppercase ml-1"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="tools-form" name="tools-form" enctype="multipart/form-data" class="form-horizontal mb-0">
        @csrf
        <div class="modal-body">
          <div class="row mb-3 barcodes">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col">
              <input type="text" name="barcode" id="barcode" class="form-control color-red" value="" readonly="">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="category" class="form__label">Tool Category</label>
              <select class="form__input" name="category" id="category">
              </select>
            </div>
            <div class="col">
              <label for="description" class="form__label">Tool Name</label>
              <select class="form__input" name="description" id="description">
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <label for="brand" class="form__label">Brand Name</label>
                <input type="text" class="form__input" name="brand" id="brand" placeholder="Brand Name" autocomplete="off">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="property" class="form__label">Property Number</label>
                <input type="text" class="form__input" name="property" id="property" placeholder="Property Number" autocomplete="off">
              </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="source" class="form__label" style="width:100%; display:block;">Source</label>
                    <select class="form__input" name="source" id="source">
                    </select>
                </div>
            </div>
          </div>
         
        </div>
        <div class="modal-footer justify-right">
          <input type="hidden" class="form__input" name="admin_num" id="admin_num" value="{{ Auth()->user()->id }}">
          <input type="hidden" class="form__input" name="toolId" id="toolId">
          <input type="hidden" class="form__input" name="action_btn" id="action_btn">
          @permission('tools-print')
          <button type="button" class="btn btn-sm btn-success text-uppercase m-2 p-2 mr-2 ml-2" id="print-tools">
            <i class="fas fa-file-pdf mr-2"></i>
            PDF
          </button>
          @endpermission
          <button type="submit" class="btn btn-sm btn-primary text-uppercase" id="save-tools">
            <i class="fas fa-save mr-2"></i>
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</div>