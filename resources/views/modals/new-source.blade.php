<div class="modal fade show" id="source" >
    <div class="modal-dialog modal-sm width-college">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">add source</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="source-form">
                @csrf
                    <div class="form-group">
                        <label for="description" class="form__label ml-2 pl-1">Source Description</label>
                        <input type="text" class="form__input" name="description" id="description" placeholder="Source Description" autocomplete="off">
                    </div>
                
            </div>
            <div class="modal-footer">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="action">
                <button type="submit" id="save-data" class="btn btn-primary text-uppercase">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
