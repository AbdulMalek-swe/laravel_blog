<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    //
    public function signup(Request $request){
       try{
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();
           // Generate a token for the created user
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'User signed up successfully.',
            'token' => $token
        ],201);
       }catch (\Exception $exception) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to sign up user.',
            'error' => $exception->getMessage()
        ], 500); // 500 Internal Server Error status code
    }
    }
    public function login(Request $request){
        //  $user = User::all();
         $user = User::where('email', $request->email)->first();
         if( !$user){
            return response()->json(['error' => 'user not find'], 400);
          }
      if(!Hash::check($request->password,$user->password)){
        return response()->json(['error' => 'wrong password'], 400);
      }
      $credentials = $request->only('email', 'password');
      if (!$token = JWTAuth::attempt($credentials)) {
          return response()->json(['error' => 'invalid_credentials'], 400);
      }
         return response()->json([
            'success' => true,
            'message' => 'User signed up successfully.',
            'token' => $token,
            
        ],201);
    }
    public function getMe(){
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }
}
