<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;


// Check server run
Route::get('connect', function() {
    return response()->json([
        'status' => 200,
        'message' => 'Is connect!'
    ]);
});

// User
Route::group([
    'prefix' => 'user',
    'middleware' => 'api'
], function($router) {

    $router->post('/register', [UserController::class, 'register'])->name('user.register');

    $router->post('/login', [UserController::class, 'login'])->name('user.login');

    $router->get('/profile', [UserController::class, 'profile'])->name('user.profile');

    $router->post('/logout', [UserController::class, 'logout'])->name('user.logout');

    $router->post('/profile/name', [UserController::class, 'updateName'])->name('user.name.update');

    $router->post('/profile/password', [UserController::class, 'updatePassword'])->name('user.password.update');
});

// Record
Route::group([
    'prefix' => 'record',
    'middleware' => ['api', 'auth']
], function($router) {

    $router->post('/daily', [RecordController::class, 'createDaily'])->name('daily.create');

    $router->patch('/daily/{date}', [RecordController::class, 'updateDaily'])->name('daily.update');

    $router->get('/daily/{date}', [RecordController::class, 'searchDaily'])->name('daily.search');

    $router->post('/diet', [RecordController::class, 'createDiet'])->name('diet.create');

    $router->patch('/diet', [RecordController::class, 'updateDiet'])->name('diet.update');
});
