<?php

namespace App\Http\Requests\Records;

use App\Http\Requests\BaseRequest;

class CreateDailyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'bail|required|date_format:Y-m-d|unique:dailies,date',
            'weight' => 'bail|nullable|numeric|min:1',
            'body_fat' => 'bail|nullable|numeric|max:1',
            'awake' => 'bail|nullable|date_format:H:i',
            'sleep' => 'bail|nullable|date_format:H:i',
            'water_morning' => 'bail|nullable|numeric|min:0',
            'water_afternoon' => 'bail|nullable|numeric|min:0',
            'water_evening' => 'bail|nullable|numeric|min:0',
            'water_another' => 'bail|nullable|numeric|min:0',
            'coffee' => 'bail|nullable|numeric|min:0',
            'tea' => 'bail|nullable|numeric|min:0',
            'sport' => 'bail|nullable|string',
            'defecation' => 'bail|nullable|string',
            'note' => 'bail|nullable|string'
        ];
    }
}
