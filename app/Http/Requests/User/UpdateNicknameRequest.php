<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateNicknameRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'nickname' => 'bail|required|string',
        ];
    }
}
