<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdatePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|string|confirmed|min:6',
        ];
    }
}
