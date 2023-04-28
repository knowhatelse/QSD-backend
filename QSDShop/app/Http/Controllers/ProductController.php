<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = Product::all();

        if($products->count() > 0){
            return response()->json([
                'status' => 200,
                'products' => $products
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
    public function store(StoreProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required|string',
            'price' =>'required|float',
            'category_id' =>'required|integer',
            'brand_id' =>'required|integer',
            'color_id' =>'required|integer',
            'product_rating_id' =>'integer',
            'image_id' =>'required|integer',
            'availability_state' =>'required|string',
            'gender' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }else{
            $products = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'color_id' => $request->color_id,
                'product_rating_id' => $request->product_rating_id,
                'image_id' => $request->image_id,
                'availability_state' => $request->availability_state,
                'gender' => $request->gender,
            ]);

            if($products){
                return response()->json([
                    'status' => 200,
                    'message' => 'Product added successfully'
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
    public function show($id) //It was 'Product $product' in the parameters.
    {
        $product = Product::find($id);

        if($product){
            return response()->json([
                'status' => 200,
                'product' => $product
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No product have been found with the given id!'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateProductRequest $request) //It was 'UpdateProductRequest $request, Product $product' in the parameters
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required|string',
            'price' =>'required|float',
            'category_id' =>'required|integer',
            'brand_id' =>'required|integer',
            'color_id' =>'required|integer',
            'product_rating_id' =>'integer',
            'image_id' =>'required|integer',
            'availability_state' =>'required|string',
            'gender' =>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);

        }else{
            $product = Product::find($id);

            if($product){
                $product->update([
                    'name' => $request->name,
                    'price' => $request->price,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'color_id' => $request->color_id,
                    'product_rating_id' => $request->product_rating_id,
                    'image_id' => $request->image_id,
                    'availability_state' => $request->availability_state,
                    'gender' => $request->gender,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Product added successfully'
                ],200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No such product has been found in the database!'
                ],404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) //It was 'Product $product' in the parameters.
    {
        $product = Product::find($id);

        if($product){
            $product->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully'
            ],404);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such product has been found in the database!'
            ],404);
        }
    }
}
