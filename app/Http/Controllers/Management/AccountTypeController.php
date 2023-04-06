<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\AccountType;
use App\Http\Requests\AccountTypeRequest;
use App\Http\Requests\AccountTypeUpdateRequest;

use Str;
use Auth;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts =AccountType::latest()->get();

        // foreach ($accounts as $key) {
        //     $key->update([
        //         'uuid' =>(string)Str::orderedUuid()
        //     ]);
        // }
        return view('managements.system_parts.accounts',compact('accounts'));
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
    public function store(AccountTypeRequest $request)
    {
        $valid_data =$request->validated();
        $account =AccountType::create([
            'name'        =>ucwords($valid_data['name']),
            'name_sw'     =>ucwords($valid_data['name_sw']),
            'description' =>$valid_data['description'],
            'uuid'        =>(string)Str::ordereduuid(),
            'created_by'  =>Auth::user()->id,
        ]);

        return response()->json([
            'success' =>true,
            'message' =>"Account Type Created Successfully",
        ]);
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
    public function update(AccountTypeUpdateRequest $request)
    {
        $valid_data =$request->validated();
        $account =Accounttype::where('uuid',$valid_data['uuid'])->first();
        $account->name =ucwords($valid_data['name']);
        $account->name_sw =ucwords($valid_data['name_sw']);
        $account->description =$valid_data['description'];
        $account->updated_by  =Auth::user()->id;
        $account->save();

        return response()->json([
            'success' =>true,
            'message' =>"Account Type Updated Successfully",
        ]);


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
