<?php

namespace App\Http\Requests\Employee\Product\CreateProduct;

use Illuminate\Foundation\Http\FormRequest;

class UploadCoverRequest extends FormRequest
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
            'gameId' => 'required|integer',
            'small' => 'required|file|dimensions:width=460|dimensions:height=215|mimes:jpg,svg,png',
            'store_header_image' => 'required|file|dimensions:width=231|dimensions:height=87|mimes:jpg,svg,png',
            'poster' => 'required|file|dimensions:width=600|dimensions:height=800|mimes:jpg,svg,png',
            'screen' => 'required|min:5',
            'screen.*' => 'required|file|dimensions:width=1920|dimensions:height=1080|mimes:jpg,svg,png',
            'background_image' => 'file|mimes:jpg,svg,png',
        ];
    }

    public function messages()
    {
        return [
            'small.required' => 'Не загружено изображение',
            'small.dimensions' => 'Размер изображения должно быть 460x215px',
            'small.mimes' => 'Допустий формат файла: jpg, svg, png',
            'store_header_image.required' => 'Не загружено изображение',
            'store_header_image.dimensions' => 'Размер изображения должно быть 231x87px',
            'store_header_image.mimes' => 'Допустий формат файла: jpg, svg, png',
            'poster.required' => 'Не загружено изображение',
            'poster.dimensions' => 'Размер изображения должно быть 600x800px',
            'poster.mimes' => 'Допустий формат файла: jpg, svg, png',
            'screen.required' => 'Не загружены изображения',
            'screen.min' => 'Минимум 5 изображений',
            'screen.dimensions' => 'Размер изображения должно быть 1920x1080px',
            'screen.mimes' => 'Допустий формат файла: jpg, svg, png',
        ];
    }
}
