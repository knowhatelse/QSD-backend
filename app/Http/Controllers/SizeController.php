<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
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

    public function getSizes(): JsonResponse {
        $sizes = Size::all();

        if($sizes->count() > 0) {
            return $this->recordResponse($sizes);
        }else{
            return $this->infoResponse(404,'No records found in the database...');
        }
    }

    public function addSize(Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'size' => 'string|required'
        ]);

        $sizes = Size::all();
        foreach ($sizes as $s){
            if($s->size == $request->size){
                return $this->infoResponse(422, 'The size already exists!');
            }
        }

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }else{
            $size = Size::create([
                'size' => $request->size
            ]);
        }

        if($size){
            return $this->infoResponse(200, 'Request added successfully!', $size);
        }else {
            return $this->infoResponse(500, 'Something went wrong!');
        }
    }

    public function updateSize($id, Request $request): JsonResponse {
        $validator = Validator::make($request->all(), [
            'size' => 'string|required'
        ]);

        if($validator->fails()){
            return $this->infoResponse(422, $validator->messages());
        }else{
            $size = Size::find($id);

            if(!$size){
                return $this->infoResponse(404, 'No record found in the database with the given id...');
            }

            $size -> update([
                'size' => $request->size
            ]);
        }

        if($size){
            return $this->infoResponse(200, 'Request updated successfully!', $size);
        } else {
            return $this->infoResponse(500, 'Something went wrong!');
        }
    }

    public function deleteSize($id): JsonResponse {
        $size = Size::find($id);

        if($size){
            $size->delete();
            return $this->infoResponse(200, 'The record has been successfully deleted!');
        } else {
            return $this->infoResponse(404, 'No record found in the database with the given id...');
        }
    }
}
