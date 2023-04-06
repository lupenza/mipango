<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\Bank;
use App\Models\Management\AccountType;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;
use Str;
use Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks =Bank::with('account_type')->latest()->get();
        $account_types =AccountType::get();
        return view('managements.system_parts.banks',compact('banks','account_types'));
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
    public function store(BankStoreRequest $request)
    {
        $valid_data =$request->validated();
        $bank =Bank::create([
            'name'        =>ucwords($valid_data['name']),
            'common_name'     =>ucwords($valid_data['common_name']),
            'account_type_id' =>$valid_data['account_type_id'],
            'uuid'            =>(string)Str::orderedUuid(),
            'created_by'      =>Auth::user()->id
        ]);

        return response()->json([
            'success' =>true,
            'message' =>"Bank Created Successfully",
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
    public function update(BankUpdateRequest $request)
    {
        $valid_data =$request->validated();
        $bank =Bank::where('uuid',$valid_data['uuid'])->first();
        $bank->name =ucwords($valid_data['name']);
        $bank->common_name =ucwords($valid_data['common_name']);
        $bank->updated_by   =Auth::user()->id;
        $bank->save();

        return response()->json([
            'success' =>true,
            'message' =>"Bank Updated Successfully",
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
