<div class="modal fade show" id="add-course" >
    <div class="modal-dialog modal-sm width-course">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase">add course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="course-form" name="course-form" enctype="multipart/form-data" class="form-horizontal mb-0">
                    @csrf
                    <div class="form-group">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="college" class="form__label">College</label>
                                    <select class="form__input" name="college" id="college">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form__label ml-2 pl-1">Course Name</label>
                        <input type="text" class="form__input" name="description" id="description" placeholder="Course Name" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="code" class="form__label ml-2 pl-1">Course Code</label>
                        <input type="text" class="form__input" name="code" id="code" placeholder="Course Code" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="action-course">
                <button type="submit" id="save-data" class="btn btn-primary text-uppercase">Submit</button>
            </div>
                </form>
        </div>
    </div>
</div>
