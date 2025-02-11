<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class UpdateNameRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'bail|required|string',
        ];
    }
}
