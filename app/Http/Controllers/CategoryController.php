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

    private function checkCategories($request){
        $categories = Category::all();
        foreach($categories as $c){
            if($c->name == $request->name){
                return true;
            }
        }
        return false;
    }


    //Category endpoint
    public function getCategories(): JsonResponse {
        $categories = Category::all();

        if($categories->count() > 0){
            return $this->infoResponse(200, '', $categories);
        }else{
            return $this->infoResponse(404, 'No categories were found in the database...');
        }
    }

    public function addCategory(Request $request): JsonResponse {
        $validator = Validator::make($request->all(),[
            'name' => 'string|required'
        ]);

        if($this->checkCategories($request)){
            return $this->infoResponse(422, 'This category already exists!');
        }

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }else{
            $category = Category::create([
                'name' => $request->name
            ]);
        }

        if($category){
            return $this->infoResponse(200, 'Category added successfully!');
        }else{
            return $this->infoResponse(500, 'Something went wrong!');
        }
    }

    public function updateCategory($id, Request $request): JsonResponse {
        $validator = Validator::make($request->all(),[
            'name' => 'string|required'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        if($this->checkCategories($request)){
            return $this->infoResponse(422, 'This category name has been already taken!');
        }

        $category = Category::find($id);

        if(!$category){
            return $this->infoResponse(404, 'No category was found in the database with the given id...');
        }else{
            $category->update([
                'name' => $request->name
            ]);
        }

        if($category){
            return $this->infoResponse(200, 'The category was successfully updated', $category);
        }else{
            return $this->infoResponse(500, 'Something went wrong!');
        }
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
