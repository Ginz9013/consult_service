<?php

namespace App\Http\Requests\Records;

use App\Http\Requests\BaseRequest;

class CreateDietaryRecordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'time' => 'bail|required|date_format:H:i',
            'staple' => 'bail|nullable|numeric|min:0',
            'meat' => 'bail|nullable|numeric|min:0',
            'fruit' => 'bail|nullable|numeric|min:0',
            'vegetable' => 'bail|nullable|numeric|min:0',
            'fat' => 'bail|nullable|numeric|min:0',
            'description' => 'bail|nullable|string',
            'image1' => 'nullable|image|max:1024',
            'image2' => 'nullable|image|max:1024',
            'image3' => 'nullable|image|max:1024',
        ];
    }
}
