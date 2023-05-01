<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\PermissionCategory;
use App\Models\Management\Permission;
use Str;
use Auth;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $permissions =Permission::with('permission_category')->get();
         $categories  =PermissionCategory::get();
       // $permissions =[];
        //$categories =[];
        return view('users.permissions',compact('permissions','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('Create Permission')) {
            abort( response()->json([
                'success' =>false,
                'errors'  =>'You dont have permission to perform this action !!!!!'
            ],401) );
        }
        $valid =$this->validate($request,[
            'name'         =>['required','unique:permissions,name'],
            'description' =>'required',
            'category'    =>'required'
        ]);

        $role =Permission::create([
            'name'        =>ucwords($valid['name']),
            'description' =>$valid['description'],
            'permission_category_id' =>$valid['category'],
            'uuid'                   =>(string)Str::orderedUuid(),
        ]);

        return response()->json([
            'success' =>true,
            'message' =>"Permission Registered Successfully"
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
