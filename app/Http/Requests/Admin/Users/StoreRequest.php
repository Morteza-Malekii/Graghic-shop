<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'name'=>['required','string','min:3','max:255'],
            'email'=>['required','max:255', 'unique:users,email'],
            'mobile'=>['required','regex:/^09[0-9]{9}$/','unique:users,mobile'],
            'role'=>['required', Rule::in(['admin','user'])],
            'password'=>['required','string','min:8','confirmed']
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.regex' => 'شماره موبایل باید با 09 و 11 رقم باشد.',
            'role.in'      => 'نقش باید یکی از مقادیر admin یا user باشد.',
        ];
    }
}
