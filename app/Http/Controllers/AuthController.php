<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    // 從 Route Group 中統一套用的 api Middleware 把 login / register 方法排除
    public function __construct() {
        
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
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

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'status' => 201,
            'message' => 'User successfully registered.',
            'user' => $user
        ]);
    }

    // Login
    public function login(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 401);
        };

        $token = auth()->attempt($validator->validated());

        if(!$token) {
            return response()->json(['error' => 'Unauthorized', 401]);
        };

        return $this->createNewToken($token);
    }

    private function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
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
            'message' => 'User logged out.'
        ]);
    }
}
