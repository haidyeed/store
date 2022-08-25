<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Traits\Response;

use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $categories= Category::all();

       return response()->json([
        'success' => true,
        'message' => 'a list of all categories',
        'data' => $categories
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = $request->only(['name', 'description']);

        if($request->has('status')) {
            $category['status']=$request->status;
        }
        else{
            $category['status']=0;
        }

        if($request->has('order')){

            $category['order'] = $request->order;
        }
        else{
            $category['order'] = 0;
        }

        if($request->has('image')){
            $name=round(microtime(true) * 1000).'.'.request()->image->getClientOriginalExtension();
            request()->image->storeAs('public/products_images/',$name);
            $category['image'] ='public/products_images/'.$name;

        }

        $validate_data = [
            'name' => 'required|string|min:4',
            'description' => 'required|string|min:10',
            'status' => 'numeric|min:0|max:1',
            'order' => 'numeric|min:0',
            'image' =>'required'

        ];

        $validator = Validator::make($category, $validate_data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }


        $category = Category::create([
            'name' => $category['name'],
            'description' => $category['description'],
            'image' => $category['image'],
            'status' => $category['status'],
            'order' => $category['order'],

        ]);

        return response()->json([
            'success' => true,
            'message' => 'a new category has been added successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $category= Category::find($id);

       if($category)
       return response()->json([
        'success' => true,
        'message' => 'category',
        'data' => $category
    ], 200);
    else
    return response()->json([
        'success' => false,
        'message' => 'this category is not found',
    ], 404);

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
        $category = Category::find($id);
        if($category){

         $data = $request->only(['name', 'description','image','status','order']);

         $validate_data = [
            'name' => 'string|min:4',
            'description' => 'string|min:10',
            'status' => 'numeric|min:0|max:1',
            'order' => 'numeric|min:0',
        ];

        $validator = Validator::make($data, $validate_data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }

        $category->fill($data)->save();

            return response()->json([
                'success' => true,
                'message' => 'category updated successfully'
            ], 200);

        }

        else {

            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::find($id);
        if($category){

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'category deleted successfully'
            ], 200);

        }

        else {

            return response()->json([
                'success' => false,
                'message' => 'category not found'
            ], 400);

        }

    }
}
