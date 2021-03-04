<div class="modal fade" id="editRoles">
  <div class="modal-dialog modal-lg modal-default">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-uppercase">Edit {{ $modelKey }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form
            method="POST"
            action="{{route('admintrust.roles-permission.update', ['roles_permission' => $user->id, 'model' => $modelKey])}}"
            class="form-roles align-middle inline-block min-w-full overflow-hidden sm:rounded-lg border-b font-weight-normal border-gray-200 p-8"
        >
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-4">
                    <label class="form__label">Name</label>
                    <input
                        class="form__input user-name mt-1 block w-full"
                        name="name"
                        placeholder=""
                        value=""
                        readonly
                        autocomplete="off"
                    >
                </div>
                <div class="col-1"></div>
                <div class="col">
                    <label class="form__label">Roles</label>
                    <div class="roles">
                        
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <label class="form__label mt-4">Permissions</label>
                    <div class="permissions">
                        
                    </div>
                </div>
            </div>
           <div class="row">
               <div class="col d-flex justify-content-end">
                        <button class="btn btn-sn btn-blue" type="submit">Save</button>
               </div>
           </div>
        </form>
      </div>
    </div>
  </div>
</div>