<?php

namespace App\Http\Controllers;


use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\UpdateNameRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Service\UserService;
use App\Http\Resources\Auth\UserLoginResource;
use App\Http\Response\ApiResponse;

class UserController extends Controller
{
    protected $userService;

    // 從 Route Group 中統一套用的 api Middleware 把 login / register 方法排除
    public function __construct(UserService $userService) {

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userService = $userService;
    }

    // Register
    public function register(RegisterUserRequest $request) {

        $user = $this->userService->registerUser($request->validated());

        return (new ApiResponse(
            201,
            '使用者註冊成功',
            ['user' => $user]
        ))->toJson();
    }

    // Login
    public function login(LoginUserRequest $request) {

        $token = $this->userService->login($request->validated());

        if(!$token) {
            return (new ApiResponse(401, 'Unauthorized'))->toJson();
        };

        return (new ApiResponse(
            200,
            "登入成功",
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => new UserLoginResource(auth()->user())
            ]
        ))->toJson();
    }

    // Profile
    public function profile() {

        $user = auth()->user();

        return $user
            ? (new ApiResponse(200, '取得使用者資訊', $user))->toJson()
            : (new ApiResponse(400, "沒有該使用者"))->toJson();
    }

    // Logout
    public function logout() {

        auth()->logout();

        return (new ApiResponse(200, '登出成功'))->toJson();
    }

    // Update Profile Name
    public function updateName(UpdateNameRequest $request) {

        $updated = $this->userService->updateProfileName($request->validated());

        return $updated
            ? (new ApiResponse(200, '更新成功'))->toJson()
            : (new ApiResponse(400, '更新失敗'))->toJson();
    }

    // Update Profile Password
    public function updatePassword(UpdatePasswordRequest $request) {

        $updated = $this->userService->updateProfilePassword($request->validated());

        return $updated
            ? (new ApiResponse(200, '更新成功'))->toJson()
            : (new ApiResponse(400, '更新失敗'))->toJson();
    }
}
