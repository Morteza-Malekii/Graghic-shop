<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required|min:3|max:128',
            'category_id'=> 'required|exists:categories,id',
            'price'=> 'required|numeric',
            'thumbnail_url'=> 'nullable|image|mimes:jpeg,jpg,png,gif,svg,bmp,webp,ico,tiff',
            'demo_url'=> 'nullable|image|mimes:jpeg,jpg,png,gif,svg,bmp,webp,ico,tiff',
            'source_url'=> 'nullable|image|mimes:jpeg,jpg,png,gif,svg,bmp,webp,ico,tiff',
            'description'=> 'required|min:10',
        ];
    }
}
