<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateAvatarPictureRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'avatar_pic' => 'bail|required|image|max:1024',
        ];
    }
}
