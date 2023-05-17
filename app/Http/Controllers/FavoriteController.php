<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function getFavorites(){
        $user = Auth::user();
        $favorites=Favorite::with('products')->where('user_id',$user->id)->get();
        return response()->json([$favorites]);
    }

}
