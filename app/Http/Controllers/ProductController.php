<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    //Private function
    private function infoResponse($status, $message, $record = null): JsonResponse {
        return response()->json([
            'message' => $message,
            'product' => $record
        ],$status);
    }

    private function storeProductImages(Request $request, Product $product): void {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $image->hashName();
                $image->storeAs('public/images/products', $imageName);
                $product->images()->create([
                    'name' => $imageName,
                    'product_id' => $product->id
                ]);
            }
        }
    }


    //API methods
    public function getProducts(): JsonResponse {
        $products = Product::with('brands','colors', 'categories', 'sizes', 'images')->paginate(20);
        return $this->infoResponse(200, '', $products);
    }

    public function getProductById($id): JsonResponse {
        $validator = Validator::make(['id' => $id], [
            'id' => 'exists:products,id'
        ]);

        if($validator->fails()){
            return $this->infoResponse(404, $validator->messages());
        }

        $products = Product::with('brands','colors', 'categories', 'sizes', 'images')->find($id);
        return $this->infoResponse(200, '', $products);
    }

    public function addProduct(Request $request): JsonResponse {
        $validator = Validator::make($request->all(),[
            'name'=> 'string|required|unique:products,name',
            'price' => 'numeric|required|min:1.0|max:5000.0',
            'gender' => 'integer|required|in:1,2,3',
            'brand_id' => 'integer|required|exists:brands,id',
            'color_id' => 'integer|required|exists:colors,id',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|exists:categories,id',
            'sizes' => 'required|array',
            'sizes.*.size_id' => 'required|integer|exists:sizes,id',
            'sizes.*.amount' => 'required|integer|min:1|max:100',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'gender' => $request->gender,
            'brand_id' => $request->brand_id,
            'color_id' => $request->color_id,
        ]);

        $this->storeProductImages($request, $product);

        $product->categories()->sync($request->categories);
        $product->sizes()->sync($request->sizes);

        return $this->infoResponse(200, 'Product added successfully!');
    }

    public function updateProduct(Request $request): JsonResponse {
        $validator = Validator::make($request->all(),[
            'id' => 'numeric|required|exists:products,id',
            'name' => ['required',Rule::unique('products')->ignore($request->id),'string'],
            'price' => 'numeric|required|min:1.0|max:5000.0',
            'gender' => 'integer|required|in:1,2,3',
            'brand_id' => 'integer|required|exists:brands,id',
            'color_id' => 'integer|required|exists:colors,id',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|exists:categories,id',
            'sizes' => 'required|array',
            'sizes.*.size_id' => 'required|integer|exists:sizes,id',
            'sizes.*.amount' => 'required|integer|min:1|max:100',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, 'You need to add a new image');
        }

        $product = Product::find($request->id);

        $existingImageCount = $product->images()->count();
        $newImageCount = count($request->images);
        $maxImageCount = 5;

        if ($existingImageCount + $newImageCount > $maxImageCount) {
            $remainingSlots = $maxImageCount - $existingImageCount;
            return $this->infoResponse(400, "Product already has $existingImageCount images. You can add up to $remainingSlots more images.");
        }

       $this->storeProductImages($request, $product);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'gender' => $request->gender,
            'brand_id' => $request->brand_id,
            'color_id' => $request->color_id,
        ]);

        $product->categories()->sync($request->categories);
        $product->sizes()->sync($request->sizes);

        return $this->infoResponse(200, 'Product updated successfully!', $product);
    }

    public function deleteProduct($id): JsonResponse {
        $validator = Validator::make(['id' => $id], [
            'id' => 'exists:products,id'
        ]);

        if($validator->fails()){
            return $this->infoResponse(404, $validator->messages());
        }

        $product = Product::find($id);

        $product->images()->delete();
        $product->categories()->detach();
        $product->sizes()->detach();
        $product->delete();

        return $this->infoResponse(200, 'The product was successfully deleted!');
    }
}
