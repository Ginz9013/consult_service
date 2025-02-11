<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class RegisterUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
            'email' => 'bail|required|string|email|unique:users',
            'password' => 'bail|required|string|confirmed|min:6',
            'weight' => 'bail|nullable|numeric',
            'body_fat' => 'bail|nullable|numeric|max:1',
            'next_consultation' => 'bail|nullable|date_format:Y-m-d',
        ];
    }
}
