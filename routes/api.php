<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecordController;
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

// Record
Route::group([
    'prefix' => 'record',
    'middleware' => ['api', 'auth']
], function($router) {

    $router->post('/daily', [RecordController::class, 'createDailyRecord']);

    $router->patch('/daily/{date}', [RecordController::class, 'updateDailyRecord']);

    $router->get('/daily', [RecordController::class, 'SearchDailyRecords']);

    $router->post('/diet', [RecordController::class, 'createDietaryRecord'])->name('dietary.create');

    $router->patch('/diet', [RecordController::class, 'updateDietaryRecord'])->name('dietary.update');
});
