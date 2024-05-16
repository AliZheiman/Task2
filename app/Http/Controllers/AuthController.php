<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function Register(Request $request){
        $request->validate([
            "name"              =>    "required|string",
            "email"             =>    "required|email",
            "password"          =>    "required|confirmed",
            "phone"             =>    "required|numeric",
            "certificate"       =>    "required"
        ]);

        $user = User::create([
            "name"              =>    $request->name,
            "email"             =>    $request->email,
            "password"          =>    bcrypt($request->password),
            "phone"             =>    $request->phone,
            "certificate"       =>    $request->certificate,
        ]);
        return response([
            "isSuccess"         =>    true,
            "msg"               =>    "Register is Done"
        ],200);
    }

    public function LogIn(Request $request){
        $request->validate([
            'email'             => 'required|email',
            'phone'             => 'required|numeric',
            'password'          => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->email)->plainTextToken;
    }
}
