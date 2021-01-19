<div class="modal fade show" id="college" >
    <div class="modal-dialog modal-sm width-college">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">add college</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="college-form">
                @csrf
                    <div class="form-group">
                        <label for="code" class="form__label ml-2 pl-1">College Code</label>
                        <input type="text" class="form__input" name="code" id="code" placeholder="College Code" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="description" class="form__label ml-2 pl-1">College Name</label>
                        <input type="text" class="form__input" name="description" id="description" placeholder="College Name" autocomplete="off">
                    </div>
                
            </div>
            <div class="modal-footer">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="action">
                <button type="submit" id="save-data" class="btn btn-primary text-uppercase">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
