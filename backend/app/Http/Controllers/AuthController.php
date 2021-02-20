<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
 
        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }
 
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
 
        return response(['user' => auth()->user(), 'token' => $accessToken]);
 
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
 
        $validatedData['password'] = bcrypt($request->password);
 
        $user = User::create($validatedData);
 
        $accessToken = $user->createToken('authToken')->accessToken;
 
        return response([ 'user' => $user, 'token' => $accessToken]);
    }

}