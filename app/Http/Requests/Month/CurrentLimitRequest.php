<?php

namespace App\Http\Requests\Month;

use Illuminate\Foundation\Http\FormRequest;

class CurrentLimitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'limit_sum' => 'required|max:8|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
        ];
    }
}
