$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var rolesPermission = $('#rolesPermission-table').DataTable({
        searching: false,
        info: false,
        ordering: false,
    })

    const chunk = (arr, size) => {
        Array.from({
            length: Math.ceil(arr.length / size) },
            (v, i) => arr.slice(i * size, i * size + size)
        );
    };

    $(document).on('click', '#edit-roles', function(e){
        $('.add-roles').remove();
        $('.add-permissions').remove();
        var id = $(this).attr("data-id");
        var model = $(this).attr("data-model");
        $('.form-roles').attr("action", "/roles-permission/" + id + "?model="+ model +"");
        $('.roles-edit').trigger("reset");
        $.get("roles-permission/" + id + "/edit?model=" + model, function(data){
            $('.modal-title').html("Edit "+ data.user.name +"'s Permission");
            $('.user-name').val(data.user.name);
            $.each(data,function(key, value){
               
                if(key == "roles")
                {
                    $.each(data.roles, function(key, value){
                        // console.log(value.assigned == true && value.isRemovable == false);
                        if(value.assigned == true && value.isRemovable == false){
                            if(value.assigned == true){
                                $('.roles').append('<span class="add-roles col-2"><label class="inline-flex items-center mr-3 my-2" style="flex: 1 0 20%;"><input type="checkbox" class="form-checkbox focus:shadow-none focus:border-transparent text-gray-500 h-4 w-4" name="roles[]" value="'+ value.id +'" checked> <span class="ml-2 text-gray-600">'+ value.display_name +'</span></span>');
                            }else{
                                $('.roles').append('<span class="add-roles col-2"><label class="inline-flex items-center mr-3 my-2" style="flex: 1 0 20%;"><input type="checkbox" class="form-checkbox focus:shadow-none focus:border-transparent text-gray-500 h-4 w-4" name="roles[]" value="'+ value.id +'"> <span class="ml-2 text-gray-600">'+ value.display_name +'</span></span>');
                            }
                        }else{
                            if(value.assigned == true){
                                $('.roles').append('<span class="add-roles col-auto"><label class="inline-flex items-center mr-3 my-2" style="flex: 1 0 20%;"><input type="checkbox" class="form-checkbox h-4 w-4" name="roles[]" value="'+ value.id +'" checked> <span class="ml-2">'+ value.display_name +'</span></span>');
                            }else{
                                $('.roles').append('<span class="add-roles col-auto"><label class="inline-flex items-center mr-3 my-2" style="flex: 1 0 20%;"><input type="checkbox" class="form-checkbox h-4 w-4" name="roles[]" value="'+ value.id +'"> <span class="ml-2">'+ value.display_name +'</span></span>');
                            }
                        }
                    });
                    $.each(data.permissions, function(key, value){
                        if(value.assigned == true){
                            $('.permissions').append('<span class="add-permissions col-3"><label class="inline-flex items-center mr-3 my-2 text-sm" style="flex: 1 0 20%;"><input type="checkbox" class="form-checkbox h-4 w-4" name="permissions[]" value="'+ value.id +'" checked><span class="ml-2">'+ value.display_name +'</span></label></span>');
                        }else{
                            $('.permissions').append('<span class="add-permissions col-3"><label class="inline-flex items-center mr-3 my-2 text-sm" style="flex: 1 0 20%;"><input type="checkbox" class="form-checkbox h-4 w-4" name="permissions[]" value="'+ value.id +'"><span class="ml-2">'+ value.display_name +'</span></label></span>');
                        }
                    });
                }
            });
        });
    });
});