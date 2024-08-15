<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('connect', function(Request $request) {
    return response()->json([
        'status' => 200,
        'message' => 'Is connect!'
    ]);
});

Route::group([
    'prefix' => 'auth',
    'middleware' => 'api'
], function($router) {

    $router->post('/register', [AuthController::class, 'register']);

    $router->post('/login', [AuthController::class, 'login'])->name('login');

    $router->get('/profile', [AuthController::class, 'profile']);

    $router->post('/logout', [AuthController::class, 'logout']);
});
