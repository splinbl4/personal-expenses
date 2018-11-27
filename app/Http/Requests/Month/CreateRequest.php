<?php

namespace App\Http\Requests\Month;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date_format:Y-m-d|',
            'sum' => 'required|max:8|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
        ];
    }
}
