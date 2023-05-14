<?php

namespace App\Http\Controllers;

use App\Mail\ValidationMail;
use App\Models\User;
use App\Models\ValidationKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
            'password'=>'required|string',
            'validationKey'=>''
        ]);
        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>'Invalid credentials'],401);
        }
        $user=Auth::user();
        if($user->status===0){
            return response()->json(['message'=>'This user is banned.']);
        }
        if($request->filled('validationKey')){
            $validKeyModel=DB::table('validation_keys')->where('validationKey',$request->validationKey)->where('user_id',$user->id)->first();
            if(!$validKeyModel) {
                return response()->json(['message' => 'Invalid validation key']);
            }
            $tokenResult= $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at=Carbon::now()->addMinutes(60);
            $token->save();

            return response()->json(['data'=>[
                'user'=>$user,
                'access_token'=>$tokenResult->accessToken,
                'token_type'=>'Bearer',
                'expires_at'=>Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]]);
        }

            $valKey=rand(100000,999999);
            $valKeyModel=new ValidationKey([
                'user_id'=>$user->id,
                'validationKey'=>$valKey
            ]);
            $valKeyModel->save();
            Mail::to($user->email)->send(new ValidationMail($valKey));
            return response()->json(['message'=>'Validation key sent to your email.']);

    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required',
        ]);
        $user=auth()->guard('api')->user();
        if(!Hash::check($request->old_password, $user->password)){
            return response()->json(['message'=>'Wrong old password']);
        }
        $user->password=Hash::make($request->new_password);
        $user->save();
        return response()->json(['message'=>'Successfully changed']);
    }

    public function logout(){
        $user = auth()->guard('api')->user();
        if ($user) {
            $user->token()->revoke();
            return response()->json(['message' => 'Successfully logged out'], 200);
        } else {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
    }

    public function refresh(Request $request){
        $user=auth()->guard('api')->user();
        $newToken = $user->createToken('Personal Access Token');
        $token = $newToken->token;
        $token->expires_at=Carbon::now()->addMinutes(60);
        $token->save();
        return response()->json(['user' => ['user' => $user],
            'authorization' => [
                'token' => $newToken->accessToken,
                'type' => 'Bearer',]]);
    }

    public function requestValidationKey(Request $request){
        $request->validate([
            'email'=>'required|email',
        ]);
        $user=DB::table('users')->where('email',$request->email)->first();
        if($user->status===0){
            return response()->json(['message'=>'This user is banned.']);
        }
        $validationKey= rand(100000,999999);
        $validationKeyModel=new ValidationKey([
            'user_id'=>$user->id,
            'validationKey'=>$validationKey,
        ]);
        $validationKeyModel->save();
        Mail::to($user->email)->send(new ValidationMail($validationKey));
        return response()->json(['message'=>'Validation key sent to your email.',]);
    }

}
