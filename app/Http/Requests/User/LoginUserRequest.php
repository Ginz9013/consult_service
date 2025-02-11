<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class LoginUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'bail|required|string|email',
            'password' => 'bail|required|string|min:6'
        ];
    }
}
