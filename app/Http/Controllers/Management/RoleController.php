<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Management\Permission;
use Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $roles =Role::get();
        // foreach ($roles as $key) {
        //     $key->update(['uuid'=>(string)Str::orderedUuid()]);
        // }
            $roles =[];
        return view('users.roles',compact('roles'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid =$this->validate($request,[
            'name'         =>['required','unique:roles,name'],
            'description' =>'required'
        ]);

        $role =Role::create([
            'name'        =>ucwords($valid['name']),
            'description' =>$valid['description'],
            'uuid'        =>(string)Str::orderedUuid(),
        ]);

        return response()->json([
            'success' =>true,
            'message' =>"Role Registered Successfully"
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($role_uuid)
    {
        $role =Role::with('permissions')->where('uuid',$role_uuid)->first();
       // return $role->permissions;
        $permissions =Permission::where('permission_category_id',2)->get();
        return view('users.role_permissions',compact('role','permissions'));
    }


    public function rolePermissions(Request $request){
        $role_uuid =$request->role_uuid;
        $permissions =$request->permissions;


        $role =Role::with('permissions')->where('uuid',$role_uuid)->first();
        $assign_permission =$role->givePermissionTo($permissions);

        $unchecked_permissions =$role->permissions->whereNotIn('name',$permissions);

        if ($unchecked_permissions) {
            $revoke_permission =$role->revokePermissionTo($unchecked_permissions);
        }

        return response()->json([
            'success' =>true,
            'message' =>"Action Done Successfully"
        ],200);
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
        //
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
}
