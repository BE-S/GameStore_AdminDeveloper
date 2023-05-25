<?php

namespace App\Http\Requests\Employee\Product;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationReturnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'purchaseId' => 'required|numeric',
            'applicationDate' => 'required|date_format:Y-m-d H:i|after_or_equal:2023-05-23',
            'returnKey' => 'required|array'
        ];
    }
}
