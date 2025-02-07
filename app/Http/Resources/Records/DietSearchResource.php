<?php

namespace App\Http\Resources\Records;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DietSearchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'daily_id' => $this->daily_id,
            'time' => $this->time,
            'staple' => $this->staple,
            'meat' => $this->meat,
            'fruit' => $this->fruit,
            'vegetable' => $this->vegetable,
            'fat' => $this->fat,
            'description' => $this->description,
            'img_url_1' => $this->img_url_1,
            'img_url_2' => $this->img_url_2,
            'img_url_3' => $this->img_url_3,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
