<?php

namespace App\Http\Requests\Client\Login\Card;

use Illuminate\Foundation\Http\FormRequest;

class AddCardRequest extends FormRequest
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
            "number" => 'required|min:19|max:19',
            "expiry" => 'required|min:5|max:5',
            "cvc" => 'required|min:3|max:3',
        ];
    }
}
