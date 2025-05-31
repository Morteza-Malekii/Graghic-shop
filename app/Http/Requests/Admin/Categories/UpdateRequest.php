<?php

namespace App\Http\Requests\Admin\categories;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        'title' => [
            'required',
            'min:3',
            'max:128',
            Rule::unique('categories', 'title')->ignore($this->route('category'))
        ],
        'slug' => [
            'required',
            'min:3',
            'max:128',
            Rule::unique('categories', 'slug')->ignore($this->route('category'))
        ],
    ];
    }
}
