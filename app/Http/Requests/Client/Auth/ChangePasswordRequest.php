<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|between:6,20',
            'jobHash' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Введите пароль',
            'password.between' => 'Пароль должен быть от 6 до 20 символов',
        ];
    }
}
