<?php

namespace App\Http\Requests\Employee\Product\UpdateProduct;

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
            'screen.*' => 'file|dimensions:width=600|dimensions:height=337|mimes: jpg,svg,png',
            'background_image' => 'file|mimes:jpg,svg,png',
        ];
    }

    public function messages()
    {
        return [
            'small.dimensions' => 'Размер изображения должно быть 460x215px',
            'small.mimes' => 'Допустий формат файла: jpg, svg, png',
            'store_header_image.dimensions' => 'Размер изображения должно быть 231x87px',
            'store_header_image.mimes' => 'Допустий формат файла: jpg, svg, png',
            'poster.dimensions' => 'Размер изображения должно быть 600x800px',
            'poster.mimes' => 'Допустий формат файла: jpg, svg, png',
            'screen.min' => 'Минимум 5 изображений',
            'screen.*.dimensions' => 'Размер изображений должно быть 600x337px',
            'screen.*.mimes' => 'Допустий формат файла: jpg, svg, png',
        ];
    }
}
