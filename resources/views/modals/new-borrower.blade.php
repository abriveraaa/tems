<div class="modal fade" id="add-borrower">
    <div class="modal-dialog modal-xl width-borrower">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase ml-1">add user</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="borrower-form" name="borrower-form" enctype="multipart/form-data" class="form-horizontal mb-0">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-4 mt-4 text-center">
                            <div class="form-group">
                                <img id="store_image" src="/img/default-photo.png" name="hidden_image" height="233" width="233" class="popup_img"> 
                                <input type="file" class="mt-3 ml-4 pl-3" name="borrower_image" id="borrower_image" onchange="readURL(this);">
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="studnum" class="form__label">ID Number</label>
                                        <input type="text" class="form__input" name="studnum" id="studnum" placeholder="ID Number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="contact" class="form__label">Contact</label>
                                        <input type="text" class="form__input" name="contact" id="contact" placeholder="Contact" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="sex" class="form__label">Sex</label>
                                    <select class="form__input" name="sex" id="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="firstname" class="form__label">Firstname</label>
                                        <input type="text" class="form__input" name="firstname" id="firstname" placeholder="Firstname" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="midname" class="form__label">Middlename</label>
                                        <input type="text" class="form__input" name="midname" id="midname" placeholder="Middlename" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lastname" class="form__label">Lastname</label>
                                        <input type="text" class="form__input" name="lastname" id="lastname" placeholder="Lastname" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="college" class="form__label select2">College</label>
                                    <select class="form__input" name="college"  id="college"></select>
                                </div>
                            </div>
                            <div class="row test">
                                <div class="col-8">
                                    <label for="course" class="form__label select2" id="changing">Course</label>
                                    <select class="form__input" name="course"  id="course">
                                    </select>
                                </div>
                                <div class="col changing changings">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="year" class="form__label">Year</label>
                                            <input type="number" min="1" max="5" class="form__input" name="year" id="year" placeholder="Year" autocomplete="off">
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="section" class="form__label">Section</label>
                                                <input type="text" class="form__input" name="section" id="section" placeholder="Section" autocomplete="off">
                                                <input type="hidden" class="form-control" name="borrower_id" id="borrower_id">
                                                <input type="hidden" class="form-control" name="action-borrower" id="action-borrower" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-right">
                    <button type="submit" class="btn btn-primary" id="save-data">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
