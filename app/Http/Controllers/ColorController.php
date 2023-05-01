<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
class ColorController extends Controller
{
    private function infoResponse($status, $message, $record = null): JsonResponse {
        return response()->json([
            'message' => $message,
            'color' => $record
        ],$status);
    }

    private function recordResponse($record): JsonResponse {
        return response()->json([
            'colors' => $record
        ],200);
    }

    public function getColors(): JsonResponse
    {
        $colors = Color::all();

        if($colors->count() > 0){
           return $this->recordResponse($colors);
        }else{
            return $this->infoResponse(404, 'No records found in the database...');
        }
    }

    public function addColor(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
           'name' => 'string|required',
           'hex_code' => 'string|required'
        ]);

        $colors = Color::all();

        foreach ($colors as $c){
            if($c->name == $request->name){
                return $this->infoResponse(422, 'The color already exists!', $c);
            }
        }

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }else{
            $color = Color::create([
                'name' => $request->name,
                'hex_code' => $request->hex_code
            ]);
        }

        if($color){
            return $this->infoResponse(200, 'Request added successfully!', $color);
        }else {
            return $this->infoResponse(500, 'Something went wrong!');
        }
    }

    public function updateColor($id, Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'hex_code' => 'string|required'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }else{
            $color = Color::find($id);

            if(!$color){
                return $this->infoResponse(404, 'No record found in the database with the given id...');
            }

            $color->update([
                'name' => $request->name,
                'hex_code' => $request->hex_code
            ]);
        }

        if($color){
            return $this->infoResponse(200, 'Request updated successfully!', $color);
        }else {
            return $this->infoResponse(500, 'Something went wrong!');
        }
    }

    public function deleteColor($id): JsonResponse
    {
        $color = Color::find($id);

        if($color){
            $color->delete();
            return $this->infoResponse(200, 'The record has been successfully deleted!');
        }else{
            return $this->infoResponse(200, 'No record found in the database with the given id...');
        }
    }
}
