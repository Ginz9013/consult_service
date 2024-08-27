<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Check server run
Route::get('connect', function(Request $request) {
    return response()->json([
        'status' => 200,
        'message' => 'Is connect!'
    ]);
});

// Auth
Route::group([
    'prefix' => 'auth',
    'middleware' => 'api'
], function($router) {

    $router->post('/register', [AuthController::class, 'register']);

    $router->post('/login', [AuthController::class, 'login'])->name('login');

    $router->get('/profile', [AuthController::class, 'profile']);

    $router->post('/logout', [AuthController::class, 'logout']);
});
