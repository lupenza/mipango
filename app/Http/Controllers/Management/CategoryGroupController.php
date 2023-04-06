<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\CategoryGroup;
use App\Http\Requests\CategoryGroupStore;
use App\Http\Requests\CategoryGroupUpdateRequest;
use Str;
use Auth;

class CategoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =CategoryGroup::get();

        // foreach ($categories as $key) {
        //     $key->update([
        //         'uuid' =>(string)Str::orderedUuid()
        //     ]);
        // }
        return view('managements.system_parts.category_group',compact('categories'));
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
    public function store(CategoryGroupStore $request)
    {
        $valid_data =$request->validated();

        $category =CategoryGroup::create($valid_data +[
            'uuid' =>(string)Str::orderedUuid(),
            'created_by' =>Auth::user()->id
        ]);

        return response()->json([
            'success' =>true,
            'message' =>"Category group Registered Successfully",
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
    public function update(CategoryGroupUpdateRequest $request)
    {
        $valid_data =$request->validated();
        $category =CategoryGroup::where('uuid',$valid_data['uuid'])->first();
        $category->name        =ucwords($valid_data['name']);
        $category->description =$valid_data['description'];
        $category->updated_by  =Auth::user()->id;
        $category->save();

        return response()->json([
            'success' =>true,
            'message' =>"Category group updated Successfully",
        ],200);
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
