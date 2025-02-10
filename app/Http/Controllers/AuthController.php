<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\UserLoginResource;

class AuthController extends Controller
{
    protected $authService;

    // 從 Route Group 中統一套用的 api Middleware 把 login / register 方法排除
    public function __construct(AuthService $authService) {

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authService = $authService;
    }

    // Register
    public function register(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        };

        $user = $this->authService->registerUser($validator->validated());

        return response()->json([
            'status' => 201,
            'message' => 'User successfully registered.',
            'user' => $user
        ]);
    }

    // Login
    public function login(LoginRequest $request) {

        $token = $this->authService->login($request->validated());

        if(!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        };

        return response()->json([
            'status' => 200,
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => new UserLoginResource(auth()->user())
            ]
        ]);
    }

    // Profile
    public function profile() {
        return response()->json(auth()->user());
    }

    // Logout
    public function logout() {
        auth()->logout();
        return response()->json([
            'status' => 200,
            'message' => 'User logged out.'
        ]);
    }
}
