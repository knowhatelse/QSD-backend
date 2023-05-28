<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    //Helpers functions
    private function infoResponse($status, $message, $record = null): JsonResponse {
        if($record == null){
            return response()->json(['message' => $message,],$status);
        }
        if($message == ''){
            return response()->json(['size' => $record],$status);
        }
        return response()->json(['message' => $message, 'product' => $record],$status);
    }


    //Size endpoint methods
    public function getSizes(): JsonResponse {
        $sizes = Size::all();
        return $this->infoResponse(200, '', $sizes);
    }

    public function addSize(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'size' => 'string|required|unique:sizes,size'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        $size = Size::create([
            'size' => $request->size
        ]);

        return $this->infoResponse(200, 'Size added successfully!', $size);
    }

    public function updateSize(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required|exists:sizes,id',
            'size' => 'string|required|unique:sizes,size'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        $size = Size::find($request->id);

        if(!$size){
            return $this->infoResponse(404, 'No size was found in the database with the given id...');
        }

        $size -> update([
            'size' => $request->size
        ]);

        return $this->infoResponse(200, 'Size updated successfully!', $size);
    }

    public function deleteSize($id): JsonResponse {
        $size = Size::find($id);

        if($size){
            $size->delete();
            return $this->infoResponse(200, 'The size has been successfully deleted!');
        } else {
            return $this->infoResponse(404, 'No sizes was found in the database with the given id...');
        }
    }
}
