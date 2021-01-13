<div class="modal fade" id="add-admin">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-uppercase ml-1"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="admin-form" name="admin-form" enctype="multipart/form-data" class="form-horizontal mb-0">
            @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <div class="form-group">
                                <img id="store_image" src="/img/default-photo.png" name="hidden_image" height="233" width="233" class="popup_img"> 
                                <input type="file" class="mt-3 ml-1" name="admin_image" id="admin_image" onchange="readURL(this);">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="name" class="form__label">Fullname</label>
                                        <input type="text" class="form__input" name="name" id="name" placeholder="Ex: Juan A. Dela Cruz" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col email-change">
                                    <div class="form-group">
                                        <label for="email" class="form__label">Email Address</label>
                                        <input type="email" class="form__input" name="email" id="email" placeholder="Ex: Email Address" autocomplete="off">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row chance">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="password" class="form__label">Password</label>
                                        <input type="password" class="form__input" name="password" id="password" placeholder="Password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="password" class="form__label">Confirm Password</label>
                                        <input type="password" class="form__input" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="position" class="form__label">Position</label>
                                        <input type="text" class="form__input" name="position" id="position" placeholder="Ex: Laboratory Head" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col role-change">
                                    <div class="form-group">
                                        <label for="role" class="form__label">Role</label>
                                        <input type="hidden" id="role_id" name="role_id">
                                        <select class="form__input" name="role" id="role">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-right">
                    <input type="hidden" class="action_btn">
                    <input type="hidden" name="admin_id" id="id">
                    <button type="submit" class="btn btn-primary text-uppercase" id="save-data" value="create">Save Information</button>
                </div>
            </form>
        </div>
    </div>
</div>