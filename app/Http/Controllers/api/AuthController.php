<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Services\AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(Request $request) {

        $user = $this->authService->register($request);

        if(!$user)
           return response()->json(["message" => "Error!"], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        return response()->json(["message" => "User created!"], ResponseAlias::HTTP_CREATED);

    }

    public function login(Request $request) {

        $token = $this->authService->login($request);

        if(!$token)
            return response()->json(["message" => "Invalid credentials!"], ResponseAlias::HTTP_UNAUTHORIZED);
        return response()->json(["message" => "Logged in!", "token" => $token], ResponseAlias::HTTP_OK);

    }

    public function logout() {

        $this->authService->logout();
        return response()->json(["message" => "Logged out!"], ResponseAlias::HTTP_OK);

    }
}
