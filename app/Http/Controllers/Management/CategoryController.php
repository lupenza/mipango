<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Management\Category; 
use App\Models\Management\CategoryGroup;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Str;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =Category::latest()->get();
        $category_groups =CategoryGroup::get();
        return view('managements.system_parts.categories',compact('categories','category_groups'));
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
    public function store(CategoryStoreRequest $request)
    {
        $valid_data =$request->validated();
        $category =Category::create($valid_data+[
            'uuid' =>(string)Str::orderedUuid(),
            'created_by' =>Auth::user()->id,
        ]);

        return response()->json([
            'success' =>true,
            'message' =>'Category created successfully',
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
    public function update(CategoryUpdateRequest $request)
    {
        $valid_data =$request->validated();

        $category =Category::where('uuid',$valid_data['uuid'])->first();
        $category->name        =ucwords($valid_data['name']);
        $category->name_en     =ucwords($valid_data['name_en']);
        $category->category_group =$valid_data['category_group'];
        $category->updated_by  =Auth::user()->id;
        $category->save();

        return response()->json([
            'success' =>true,
            'message' =>"Category updated Successfully",
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
