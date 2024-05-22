<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\RegisterValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginValidation $request){
        $user = User::where("email",$request->email)->first();
        if($user && Hash::check($request->password,$user->password)){
            $token = $user->createToken("accessAfterLogin")->plainTextToken;

            return response()->json(['msg' => "авторизация успешна","token" => $token]);
        }
    }

    public function register(RegisterValidation $request){
        $data = $request->validated();
        $user = User::create($data);
        if($user){
            $token = $user->createToken("accessAfterRegister")->plainTextToken;
        }

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['msg' => "токен удален"]);
    }
}
