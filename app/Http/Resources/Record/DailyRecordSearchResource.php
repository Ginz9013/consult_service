<?php

namespace App\Http\Resources\Record;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyRecordSearchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date,
            'weight' => $this->weight,
            'body_fat' => $this->body_fat,
            "awake" => $this->awake,
            "sleep" => $this->sleep,
            'water_morning' => $this->water_morning,
            'water_afternoon' => $this->water_afternoon,
            'water_evening' => $this->water_evening,
            'water_another' => $this->water_another,
            'coffee' => $this->coffee,
            'tea' => $this->tea,
            'sport' => $this->sport,
            'defecation' => $this->defecation,
            'note' => $this->note,
        ];
    }
}
