<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'weight' => $this->weight,
            'bodyFat' => $this->body_fat,
            "avatarImg" => $this->avatar_pic,
            "nextConsultation" => $this->next_consultation,
        ];
    }
}
