<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function handleFavorite(Request $request){
        $request->validate([
            'product_id'=>'required|exists:products,id',
        ]);
        $user=Auth::user();
        $product_id=$request->product_id;
        $product=Product::find($product_id);
        $existingFavorite = Favorite::where('user_id',$user->id)->where('product_id',$product_id)->first();
        if($existingFavorite){
            $existingFavorite->delete();
            $product->is_favorite = 0;
            $product->save();
            return response()->json(['message'=>'Favorite deleted successfully.']);
        }
        $favorite = new Favorite();
        $favorite->user_id=$user->id;
        $favorite->product_id=$product_id;
        $favorite->save();
        $product->is_favorite=1;
        $product->save();
        return response()->json(['message'=>'Favorite added successfully']);

    }
    public function getFavorites(){
        $user = Auth::user();
        $favorites=Favorite::with('products')->where('user_id',$user->id)->get();
        return response()->json([$favorites]);
    }
}
