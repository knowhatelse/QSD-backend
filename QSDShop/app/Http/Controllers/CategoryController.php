<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        if($category->count() > 0){
            return response()->json([
                'status' => 200,
                'products' => $category
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No records found"
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category_product_id' => 'integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }else{
            $category = Category::create([
                'name' => $request->name,
                'category_product_id' => $request->category_product_id
            ]);

            if($category){
                return response()->json([
                    'status' => 200,
                    'message' => 'Category added successfully'
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong!'
                ],500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,UpdateCategoryRequest $request) //Category $category was in the parameters
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category_product_id' => 'integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);

        }else{
            $cateory = Category::find($id);

            if($cateory){
                $cateory->update([
                    'name' => $request->name,
                    'category_product_id' => $request->category_product_id
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Category updated successfully'
                ],200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No such category has been found in the database!'
                ],404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) //Category $category was in the parameters
    {
        $category = Category::find($id);

        if($category){
            $category->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully'
            ],404);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such category has been found in the database!'
            ],404);
        }
    }
}
