<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string|min:6'
        ]);
        $user = new User([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        $user->save();
        return response()->json(['message'=>'User has been registered'],200);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|exists:users',
            'password'=>'required|string'
        ]);
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>'Invalid credentials'],401);
        }
        $user=Auth::user();
        $tokenResult= $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at=Carbon::now()->addMinutes(60);
        $token->save();

        return response()->json(['data'=>[
            'user'=>Auth::user(),
            'access_token'=>$tokenResult->accessToken,
            'token_type'=>'Bearer',
            'expires_at'=>Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]]);
    }
}
