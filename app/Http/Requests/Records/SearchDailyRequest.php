<?php

namespace App\Http\Requests\Records;

use App\Http\Requests\BaseRequest;

class SearchDailyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => 'bail|required|date|date_format:Y-m-d|before_or_equal:end_date',
            'end_date' => 'bail|required|date|date_format:Y-m-d|after_or_equal:start_date'
        ];
    }
}
