<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleUserResource;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;

use DataTables;
use Validator;
use Hash;
use Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::withTrashed()->with('roles')->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $update = Auth::user()->hasPermission('users-update');
                    $delete = Auth::user()->hasPermission('users-delete');
                    if($row->deleted_at == null){
                        if($update == true && $delete == true){
                            $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-admin" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-admin"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            $btn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="ban-admin" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-user-lock mr-2"></i>Lock</a>';
                            return $btn;
                        }else if($update == true){
                            $btn = '<a href="javascript:void(0)" class="btn btn-warning btn-sm mr-2" id="edit-admin" data-id="'. $row->id .'" data-toggle="modal" data-target="#add-admin"><i class="fas fa-pen mr-2"></i>Edit</a>';
                            return $btn;
                        }else if($delete == true){
                            $btn = '<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="ban-admin" data-id="'. $row->id .'" data-toggle="modal" data-target="#delete"><i class="fas fa-user-lock mr-2"></i>Lock</a>';
                            return $btn;
                        }else {
                            $btn = "";
                        }
                    }else{
                        if($delete == true){
                            $btn = '';
                            $btn .= '<a href="javascript:void(0)" class="btn btn-success btn-sm" id="res-admin" data-id="'. $row->id .'" data-toggle="modal" data-target="#restore"><i class="fas fa-user-check mr-2"></i>Unlock</a>';
                            return $btn;
                        }
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function createAdmin(Request $request)
    {
        $roleUser = $request->role_id;
        $image_name = $request->hidden_image;
        $image = $request->file('admin_image');

        if($image != '') 
        {
            $rules = array(
                'admin_image' => 'image|max:2048',
                'name' => 'required',
                'position' => 'required', 
                'email' => 'bail|required|email|unique:users,email', 
                'password' => 'bail|required|min:6|confirmed',
                'role' => 'required', 
            );

             $messages = array(
                'name.required' => 'Fullname is required. <br>',
                'email.required' => 'Email Address is required. <br>',
                'email.email' => 'Please enter a valid email. <br>',
                'email.unique' => 'Email is already taken. <br>',
                'password.required' => 'Password is required. <br>',
                'password.confirmed' => 'Password does not match. <br>',
                'password.min' => 'Password must be greater than 6 character. <br>',
                'role.required' => 'Role is required. <br>',
                'position.required' => 'Position is required. <br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/admin'), $image_name);

        }
        
        else
        {
            $rules = array(
                'admin_image' => 'image|max:2048',
                'name' => 'required',
                'position' => 'required', 
                'email' => 'bail|required|email|unique:users,email', 
                'password' => 'bail|required|min:6|confirmed',
                'role' => 'required', 
            );

             $messages = array(
                'name.required' => 'Fullname is required. <br>',
                'email.required' => 'Email Address is required. <br>',
                'email.email' => 'Please enter a valid email. <br>',
                'email.unique' => 'Email is already taken. <br>',
                'password.required' => 'Password is required. <br>',
                'password.confirmed' => 'Password does not match. <br>',
                'password.min' => 'Password must be greater than 6 character. <br>',
                'role.required' => 'Role is required. <br>',
                'position.required' => 'Position is required. <br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()->all()]);
            }
        }

        $userType = 'App\Models\User';
        $newUser = new User;
        $newUser->image = $image_name;
        $newUser->name = ucwords(mb_strtolower($request->name));
        $newUser->email = $request->email;
        $newUser->position = ucwords(mb_strtolower($request->position));
        $newUser->password = Hash::make($request->password);
        $newUser->save();

        $newUser->roles()->sync($roleUser, $newUser, $userType);

    	return response()->json(["success" => "Admin's record added successfully!"], 201);
    }

    public function getAdmin($admin)
    {
    	if(User::whereId($admin)->exists()) {
            $admin = User::whereId($admin)->with('roles')->first();
    		return response()->json($admin);
    	} else {
    		return response()->json([
    			"success" => "Admin not found"
    		], 404);
    	}
    }

    public function updateAdmin(Request $request)
    {
        $roleUser = $request->role_id;
        $image_name = $request->hidden_image;
        $image = $request->file('admin_image');
        
        if($image != '') 
        {
            $rules = array(
                'admin_image' => 'image|max:2048',
                'name' => 'required',
                'position' => 'required',
                'email' => 'required|unique:users,email,'.$request->admin_id,
            );

            $messages = array(
                'name.required' => 'Fullname is required. <br>',
                'position.required' => 'Position is required. <br>',
                'email.required' => 'Email is required. <br>',
                'email.unique' => 'Email has already been taken.<br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()->all()]);
            }

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/admin'), $image_name);
        }else{
            $rules = array (
                'admin_image' => 'image|max:2048',
                'name' => 'required',
                'position' => 'required',
                'email' => 'required|unique:users,email,'.$request->admin_id,
            );

            $messages = array(
                'name.required' => 'Fullname is required. <br>',
                'position.required' => 'Position is required. <br>',
                'email.required' => 'Email is required. <br>',
                'email.unique' => 'Email has already been taken.<br>',
            );

            $validate = Validator::make($request->all(), $rules, $messages);

            if($validate->fails())
            {
                return response()->json(['errors' => $validate->errors()->all()]);
            }
        }

        $user_data = array (
            'name' => ucwords(mb_strtolower($request->name)),
            'position' => ucwords(mb_strtolower($request->position)),
            'email' => $request->email,
            'image' => $image_name 
        );
        
        User::where('id', $request->admin_id)->update($user_data);
        return response()->json(['success' => "Admin's record updated successfully"]);
    }

    public function destroy($admin)
    {
        $admins = User::whereId($admin);
        $admins->delete();

        return response()->json([
            "success" => "Admin banned succesfully!"
        ], 202);
    }

    public function restore($admin)
    {
        User::withTrashed()
            ->where('id', $admin)
            ->restore();

        return response()->json(['success'=>'Record unlocked successfully.']);
    }

}
