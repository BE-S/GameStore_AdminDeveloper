<?php

namespace App\Http\Requests\Admin\Product\UpdateProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoverRequest extends FormRequest
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
            'small' => 'file|dimensions:width=460|dimensions:height=215|mimes:jpg,svg,png',
            'store_header_image' => 'file|dimensions:width=231|dimensions:height=87|mimes:jpg,svg,png',
            'poster' => 'file|dimensions:width=600|dimensions:height=800|mimes:jpg,svg,png',
            'screen' => 'min:5',
            'screen.*' => 'file|dimensions:width=1920|dimensions:height=1080|mimes:jpg,svg,png',
            'background_image' => 'file|mimes:jpg,svg,png',
        ];
    }
}
