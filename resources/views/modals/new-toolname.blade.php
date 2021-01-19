<div class="modal fade show" id="add-toolname" >
    <div class="modal-dialog modal-sm width-course">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">add toolname</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="toolname-form" name="toolname-form" enctype="multipart/form-data" class="form-horizontal mb-0">
                    @csrf
                    <div class="form-group">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="toolcategory" class="form__label">Tool Category</label>
                                    <select class="form__input" name="toolcategory" id="toolcategory">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form__label ml-2 pl-1">Tool Name</label>
                        <input type="text" class="form__input" name="description" id="description" placeholder="Tool Name" autocomplete="off">
                        <input type="hidden" id="idtoolname" name="idtoolname">
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="action-toolname">
                <button type="submit" id="save-data" class="btn btn-primary text-uppercase">Submit</button>
            </div>
                </form>
        </div>
    </div>
</div>
