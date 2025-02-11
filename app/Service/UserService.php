<?php

namespace App\Service;

use App\Models\User;

class UserService
{
    // Register
    public function registerUser(array $params) {
        $user = User::create(array_merge(
            $params,
            ['password' => bcrypt(data_get($params, 'password'))]
        ));

        return $user;
    }

    // Login
    public function login(array $credentials) {
        $token = auth()->attempt($credentials);

        return $token;
    }

    // Update Profile Name
    public function updateProfileName(array $params) {
        
        $user = auth()->user();
        $updated = $user->update([
            'name' => data_get($params, 'name'),
        ]);
        
        return $updated ? true : false;
    }

    // Update Profile Password
    public function updateProfilePassword(array $params) {
        
        $user = auth()->user();
        $updated = $user->update([
            'password' => bcrypt(data_get($params, 'password'))
        ]);

        return $updated ? true : false;
    }
}