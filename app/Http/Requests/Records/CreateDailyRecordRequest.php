<?php

namespace App\Http\Requests\Records;

use App\Http\Requests\BaseController;


class CreateDailyRecordRequest extends BaseController
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // ====== Daily ======
            'data.daily' => 'required|array',
            'data.daily.date' => 'required|date_format:Y-m-d',
            'data.daily.weight' => 'nullable|numeric|min:1',
            'data.daily.body_fat' => 'nullable|numeric|max:1',
            'data.daily.note' => 'nullable|string',
            'data.daily.water_morning' => 'nullable|numeric|min:0',
            'data.daily.water_afternoon' => 'nullable|numeric|min:0',
            'data.daily.water_evening' => 'nullable|numeric|min:0',
            'data.daily.water_another' => 'nullable|numeric|min:0',
            'data.daily.coffee' => 'nullable|numeric|min:0',
            'data.daily.tea' => 'nullable|numeric|min:0',
            
            // ====== Dietary ======
            'data.dietaries' => 'nullable|array',
            'data.dietaries.*.time' => 'required|date_format:H:i:s',
            'data.dietaries.*.staple' => 'nullable|numeric|min:0',
            'data.dietaries.*.meat' => 'nullable|numeric|min:0',
            'data.dietaries.*.fruit' => 'nullable|numeric|min:0',
            'data.dietaries.*.vegetable' => 'nullable|numeric|min:0',
            'data.dietaries.*.fat' => 'nullable|numeric|min:0',
            'data.dietaries.*.description' => 'nullable|string',
            'data.dietaries.*.images' => 'nullable|array|max:3',
            'data.dietaries.*.images.*' => 'string',
        ];
    }
}
