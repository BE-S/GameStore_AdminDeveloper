<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SigUpRequest extends FormRequest
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
            'name' =>'required|string|max:16',
            'email' => 'required|string|regex:/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/',
            'password' => 'required|string|between:6,20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Введите имя',
            'email.required' => 'Введите почту',
            'password.required' => 'Введите пароль',
            'name.size' => 'Имя должно быть меньше 16 символов',
            'password.between' => 'Пароль должен быть от 6 до 20 символов',
        ];
    }
}
