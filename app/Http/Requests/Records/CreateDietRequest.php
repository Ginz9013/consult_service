<?php

namespace App\Http\Requests\Records;

use App\Http\Requests\BaseRequest;

class CreateDietRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date_time' => 'bail|required|date_format:Y-m-d H:i',
            'staple' => 'bail|nullable|numeric|min:0',
            'meat' => 'bail|nullable|numeric|min:0',
            'fruit' => 'bail|nullable|numeric|min:0',
            'vegetable' => 'bail|nullable|numeric|min:0',
            'fat' => 'bail|nullable|numeric|min:0',
            'description' => 'bail|nullable|string',
            'image1' => 'nullable|image|mimes:jpg,jpeg|max:512',
            'image2' => 'nullable|image|mimes:jpg,jpeg|max:512',
            'image3' => 'nullable|image|mimes:jpg,jpeg|max:512',
        ];
    }
}
