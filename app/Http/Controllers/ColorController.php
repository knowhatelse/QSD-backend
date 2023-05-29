<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    //Helpers functions
    private function infoResponse($status, $message, $record = null): JsonResponse {
        if($record == null){
            return response()->json(['message' => $message,],$status);
        }
        if($message == ''){
            return response()->json(['color' => $record],$status);
        }
        return response()->json(['message' => $message, 'product' => $record],$status);
    }


    //Color endpoint methods
    public function getColors(): JsonResponse {
        $colors = Color::all();
        return $this->infoResponse(200, '', $colors);
    }

    public function addColor(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|unique:colors,name',
            'hex_code' => 'string|required|unique:colors,name'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        $color = Color::create([
            'name' => $request->name,
            'hex_code' => $request->hex_code
        ]);

        return $this->infoResponse(200, 'Color added successfully!', $color);
    }

    public function updateColor(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'id' => 'numeric|required|exists:colors,id',
            'name' => 'string|required|unique:colors,name',
            'hex_code' => 'string|required|unique:colors,hex_code'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }

        $color = Color::find($request->id);

        if(!$color){
            return $this->infoResponse(404, 'No color was found in the database with the given id...');
        }

        $color->update([
            'name' => $request->name,
            'hex_code' => $request->hex_code
        ]);

        return $this->infoResponse(200, 'Color updated successfully!', $color);
    }

    public function deleteColor($id): JsonResponse {
        $color = Color::find($id);

        if($color){
            $color->delete();
            return $this->infoResponse(200, 'The color has been successfully deleted!');
        }else{
            return $this->infoResponse(404, 'No color was found in the database with the given id...');
        }
    }
}
