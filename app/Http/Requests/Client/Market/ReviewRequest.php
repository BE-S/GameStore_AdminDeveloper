<?php

namespace App\Http\Requests\Client\Market;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'review' => 'required|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'review.required' => 'Напишите отзыв',
            'review.max' => 'Отзыв слишком длинный',
        ];
    }
}
