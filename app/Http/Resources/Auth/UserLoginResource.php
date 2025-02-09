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
            'email' => $this->email,
            'weight' => $this->weight,
            'bodyFat' => $this->body_fat,
            "avartarImg" => $this->avatar_pic,
            "nextConsultation" => $this->next_consultation,
        ];
    }
}
