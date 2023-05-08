<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    //Helpers methods
    private function infoResponse($status, $message, $record = null): JsonResponse {
        return response()->json([
            'message' => $message,
            'brand' => $record
        ],$status);
    }


    //Brand endpoint methods
    public function getBrands(): JsonResponse {
        $brands = Brand::all();
        return $this->infoResponse(200, '', $brands);
    }

    public function addBrand(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
           'name' => 'string|required|unique:brands,name'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422,$validator->messages());
        }else{
            $brand = Brand::create([
                'name' => $request->name
            ]);
        }

        return $this->infoResponse(200,'Brand added successfully!');
    }

    public function updateBrand(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required|exists:brands,id',
            'name' => 'string|required|unique:brands,name'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422,$validator->messages());
        }else{
            $brand = Brand::find($request->id);

            if(!$brand){
                return $this->infoResponse(404, 'No brand was found in the database with the given id...');
            }

            $brand->update([
                'name' => $request->name
            ]);

            return $this->infoResponse(200, 'Brand updated successfully!', $brand);
        }
    }

    public function deleteBrand($id): JsonResponse {
        $brand = Brand::find($id);

        if($brand){
            $brand->delete();
            return $this->infoResponse(200, 'The record has been successfully deleted!');
        }else{
            return $this->infoResponse(404, 'No brand was found in the database with the given id...');
        }
    }
}
