<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'profile_image' => 'required|file|mimes:jpg,jpeg,png',
        ]);
        $newName =  uniqid()."_profile_image_".$request->file('profile_image')->extension();
        $request->file('profile_image')->storeAs("public",$newName);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $newName,
        ]);
        if(Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken('phone')->plainTextToken;
            return response()->json($token);
        }
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password'=> 'required|min:8',
        ]);
        if(Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken('phone')->plainTextToken;
            return response()->json($token);
        }
        return response()->json(['message' => 'User not found!']);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message'=> 'Logout successfully!']);
    }
}
