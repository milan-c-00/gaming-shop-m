<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 0;

        $user->save();

        return response()->json(["message" => "ok"], 201);

    }

    public function login(Request $request) {

        $email = $request->email;
        $password = $request->password;

        $user = User::query()->where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)){
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json(["token" => $token, "message" => "Logged in"], 200);
        }
        else
            return response()->json(["message" => "Invalid credentials"], 403);


    }

    public function logout(Request $request) {

    }
}
