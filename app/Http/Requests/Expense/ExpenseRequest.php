<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sum' => 'required|max:8|regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/',
            'date' => 'required|date_format:Y-m-d|',
            'category_id' => 'required',
        ];
    }
}
