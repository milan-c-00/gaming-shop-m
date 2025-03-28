<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService {

    public function register($request) {

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 0;

        $user->save();

        return $user;

    }

    public function login($request){

        $email = $request->email;
        $password = $request->password;

        $user = User::query()->where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)){
            return $user->createToken('api-token')->plainTextToken;
        }
        else
            return null;

    }

    public function logout() {
        auth()->user()->tokens()->delete();
    }

}
