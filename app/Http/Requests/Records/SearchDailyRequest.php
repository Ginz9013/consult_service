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
            'date' => 'bail|required|date_format:Y-m-d',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), ['date' => $this->route('date')]);
    }
}
