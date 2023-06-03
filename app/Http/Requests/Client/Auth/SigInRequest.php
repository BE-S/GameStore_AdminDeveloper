<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SigInRequest extends FormRequest
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
            'email' => 'required|string',
            'password' => 'required|string|between:6,20',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Введите почту',
            'password.required' => 'Введите пароль',
            'between' => 'Пароль должен быть от 6 до 20 символов',
        ];
    }
}
