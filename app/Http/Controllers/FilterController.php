<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterProducts(Request $request){
        $query = Product::query();

        if($request->has('min_price')) {
            $minPrice = (float) $request->min_price;
            $query->where('price','>=',$minPrice);
        }
        if($request->has('max_price')) {
            $maxPrice = (float) $request->max_price;
            $query->where('price','<=',$maxPrice);
        }
        if($request->has('brands')){
            $brandIds= $request->brands;
            $query->whereIn('brand_id',$brandIds);
        }
        if($request->has('colors')){
            $colorIds=$request->colors;
            $query->whereIn('color_id',$colorIds);
        }
        if($request->has('genders')){
            $genderIds=$request->genders;
            $query->whereIn('gender',$genderIds);
        }
        if($request->has('sizes')){
            $sizeIds=$request->sizes;
            $query->join('product_sizes','products.id','=','product_sizes.product_id')->
            whereIn('product_sizes.size_id',$sizeIds);
        }
        if($request->has('categories')){
            $categoryIds=$request->categories;
            $query->join('product_categories','products.id','=','product_categories.product_id')->
                whereIn('product_categories.category_id',$categoryIds);
        }
        $query->with('categories', 'colors','brands','sizes');
        $products=$query->get();
        return response()->json($products);
    }
}
