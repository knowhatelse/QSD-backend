<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $request->validate([
            'name'=>'required|string',
        ]);

        $name=$request->name;
        if(strlen($name)>=2) {
            $brandIds = Brand::where('name', 'LIKE', "%$name%")->pluck('id');
            $colorIds = Color::where('name', 'LIKE', "%$name%")->pluck('id');

            $results = Product::where('name', 'LIKE', "%$name%")->orWhereIn('brand_id', $brandIds)->orWhereIn('color_id', $colorIds)->
            orWhere(function ($query) use ($name) {
                $query->whereIn('id', function ($subquery) use ($name) {
                    $subquery->select('product_id')->from('product_categories')->whereIn('category_id', function ($subquery) use ($name) {
                        $subquery->select('id')->from('categories')->where('name', 'LIKE', "%$name%");
                    });
                });
            })->
            orWhere(function ($query) use ($name) {
                $query->whereIn('id', function ($subquery) use ($name) {
                    $subquery->select('product_id')->from('product_sizes')->whereIn('size_id', function ($subquery) use ($name) {
                        $subquery->select('id')->from('sizes')->where('size', 'LIKE', "%$name%");
                    });
                });
            })->with('categories','colors','brands','sizes')->get();

            return response()->json($results);
        }
        else{
            return response()->json();
        }
    }
}
