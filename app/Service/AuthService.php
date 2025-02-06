<?php

namespace App\Service;

use App\Models\User;

class AuthService
{
    public function registerUser(array $params) {
        $user = User::create(array_merge(
            $params,
            ['password' => bcrypt(data_get($params, 'password'))]
        ));

        return $user;
    }
}