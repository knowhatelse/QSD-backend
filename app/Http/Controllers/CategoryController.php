<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //Helpers functions
    private function infoResponse($status, $message, $record = null): JsonResponse {
        return response()->json([
            'message' => $message,
            'category' => $record
        ],$status);
    }


    //Category endpoint
    public function getCategories(): JsonResponse {
        $categories = Category::all();
        return $this->infoResponse(200, '', $categories);
    }

    public function addCategory(Request $request): JsonResponse {
        $validator = Validator::make($request->all(),[
            'name' => 'string|required|unique:categories,name'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }else{
            $category = Category::create([
                'name' => $request->name
            ]);
        }

        return $this->infoResponse(200, 'Category added successfully!');
    }

    public function updateCategory(Request $request): JsonResponse {
        $validator = Validator::make($request->all(),[
            'id' => 'numeric|required|exists:categories,id',
            'name' => 'string|required|unique:categories,name'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        $category = Category::find($request->id);

        if(!$category){
            return $this->infoResponse(404, 'No category was found in the database with the given id...');
        }else{
            $category->update([
                'name' => $request->name
            ]);
        }

        return $this->infoResponse(200, 'The category was successfully updated', $category);
    }

    public function deleteCategory($id): JsonResponse {
        $category = Category::find($id);

        if($category){
            $category->delete();
            return $this->infoResponse(200, 'The category was successfully deleted!');
        }else{
            return $this->infoResponse(404, 'No category was found in the database with the given id...');
        }
    }
}
