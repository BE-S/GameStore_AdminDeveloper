<?php

namespace App\Http\Requests\Employee\Product\CreateProduct;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UploadDataRequest extends FormRequest
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
            'gameId' => 'integer',
            'name' => 'required|string|max:64',
            'price' => 'required|numeric',
            'genre' => 'array',
            'publisher' => 'required|numeric',
            'description' => 'required|string',
            'min_settings.*' => 'required|string|max:200',
            'max_settings.*' => 'required|string|max:200',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле не должно быть пустым!',
            'name.max:64' => 'Максимум 64 символов',
            'price.required' => 'Поле не должно быть пустым!',
            'price.numeric' => 'Цена указывается цифрами. Пример: 100.00',
            'description.required' => 'Поле не должно быть пустым!',
            'min_settings.*.required' => 'Поле "ОС" не должно быть пустым!',
            'max_settings.*.required' => 'Поле "ОС" не должно быть пустым!',
            'min_settings.*.max:24' => 'Максимум 24 символа',
            'max_settings.*.max:24' => 'Максимум 24 символа',
        ];
    }
}
