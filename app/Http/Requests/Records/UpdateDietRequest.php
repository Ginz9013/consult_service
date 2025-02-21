<?php

namespace App\Http\Requests\Records;

use App\Http\Requests\BaseRequest;

class UpdateDietRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'date' => 'bail|required|date_format:Y-m-d',
            'time' => 'bail|required|date_format:H:s',
            'staple' => 'bail|nullable|numeric|min:0',
            'meat' => 'bail|nullable|numeric|min:0',
            'fruit' => 'bail|nullable|numeric|min:0',
            'vegetable' => 'bail|nullable|numeric|min:0',
            'fat' => 'bail|nullable|numeric|min:0',
            'description' => 'bail|nullable|string',
            're_upload' => 'bail|required|boolean',
            'image1' => 'nullable|image|mimes:jpg,jpeg|max:512',
            'image2' => 'nullable|image|mimes:jpg,jpeg|max:512',
            'image3' => 'nullable|image|mimes:jpg,jpeg|max:512',
        ];
    }
}