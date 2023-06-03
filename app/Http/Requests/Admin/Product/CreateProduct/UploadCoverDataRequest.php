<?php

namespace App\Http\Requests\Admin\Product\CreateProduct;

use Illuminate\Foundation\Http\FormRequest;

class UploadCoverDataRequest extends FormRequest
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
            'main' => 'required|file|dimensions:width=800|dimensions:height=800|mimes:jpg,svg,png',
            'small' => 'required|file|dimensions:width=460|dimensions:height=215|mimes:jpg,svg,png',
            'header' => 'required|file|dimensions:width=120|dimensions:height=45|mimes:jpg,svg,png',
            'screen' => 'required|min:5',
            'screen.*' => 'required|file|dimensions:width=1920|dimensions:height=1080|mimes:jpg,svg,png',
            'background' => 'file|mimes:jpg,svg,png',
        ];
    }
}

//'id' => 'required',
//            'main' => 'required|file|dimensions:width=800|dimensions:height=800|mimes:jpg,svg,png',
//            'small' => 'required|file|dimensions:width=460|dimensions:height=215|mimes:jpg,svg,png',
//            'header' => 'required|file|dimensions:width=120|dimensions:height=45|mimes:jpg,svg,png',
//            'screen' => 'required|array|min:5',
//            'screen.*' => 'required|file|dimensions:width=1920|dimensions:height=1080|mimes:jpg,svg,png',
//            'background' => 'file|mimes:jpg,svg,png',
