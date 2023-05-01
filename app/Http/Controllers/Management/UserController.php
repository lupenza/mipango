<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Validator;
use App\Models\Management\Permission;
use Str;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Classes\Traits\UserExportTrait;



class UserController extends Controller
{
    use UserExportTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function userprofile($user_uuid){
        $user =User::with('accounts','ledgers','budgets','accounts.account_type')->where('uuid',$user_uuid)->first();
        return view('users.app_user_profile',compact('user'));
     }

     public function appUsers(Request $request){
        $requests =$request->all();
        $requests ? $num =null : $num =1000;
        $users =User::with('roles','accounts','budgets','ledgers')->whereHas('roles',function($query){
                    $query->where('name','User');
                })
                ->when($requests,function ($query) use ($requests){
                    $query->withFilters($requests);
                })
                 ->latest()->take($num)->get();
        return view('users.app_users',compact('users','requests'));
     }

    public function index()
    {
       // set_time_limit(0);
        // $users =User::cursor();
        // foreach ($users as $key ) {
        //     $key->update(['uuid'=>(string)Str::orderedUuid()]);
        // }
        $roles =Role::whereIn('id',[1,2])->get();
       
        $users =User::with('roles')->whereHas('roles',function($query){
            $query->where('name','Super Admin')
                  ->orWhere('name','Admin');
        })->latest()->get();
        return view('users.users',compact('roles','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\UserRequest  $UserRequest
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $UserRequest)
    {
        $user_data =$UserRequest->validated();
       // return $user_data;

        $user =User::store($user_data);

        $assign_role =$user->assignRole($user_data['user_role']);

        return response()->json([
            'success' =>true,
            'message' =>"User Registered Successfully"
        ],200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_uuid)
    {
        $user =User::where('uuid',$user_uuid)->first();
        $permissions =Permission::where('permission_category_id',1)->get();
        return view('users.edit_user',compact('user','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $request->input('email');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateUser(UserUpdateRequest $UserUpdateRequest){
       
        $user_data =$UserUpdateRequest->validated();
        $permissions =$UserUpdateRequest->permissions;

        $user =User::where('uuid',$user_data['user_uuid'])->first();
        $user->name =ucwords($user_data['name']);
        $user->name =ucwords($user_data['last_name']);
        $user->phone =preg_replace( '/^0/', '+255',$user_data['phone_number']); 
        $user->save();

        if ($permissions) {
         $assign_permission =$user->givePermissionTo($permissions);

         $unchecked_permissions =$user->permissions->whereNotIn('name',$permissions);

          if ($unchecked_permissions) {
             $revoke_permission =$user->revokePermissionTo($unchecked_permissions);
          }
            
        }else {
            $revoked_permissions =Permission::where('permission_category_id',1)->get();
            if ($revoked_permissions) {
                foreach ($revoked_permissions as $key ) {
                    $revoke_permission =$user->revokePermissionTo($key->name);
                }
            }
        }

        return response()->json([
            'success' =>true,
            'message' =>"Action Done Successfully"
        ],200);

    }

    public function changeUserStatus(Request $request){
        $user_uuid =$request->input('uuid');
        $action    =$request->input('action');

        if ($action == "activate") {
            $user_status =1;
        } else {
            $user_status =0;
        }

        $user =User::where('uuid',$user_uuid)->first();
        $user->active =$user_status;
        $user->save();

        return response()->json([
            'status' =>true,
            'message' =>'Action Performed Successfully'
        ],200);
    }

    public function generateReport(Request $request){
        $requests =$request->all();
        $requests ? $num =null : $num =1000;
        $users =User::with('roles','accounts','budgets','ledgers')->whereHas('roles',function($query){
                    $query->where('name','User');
                })
                ->when($requests,function ($query) use ($requests){
                    $query->withFilters($requests);
                })
                 ->latest()->take($num)->get();

        return $this->extendUserExport($users);
    }
}
