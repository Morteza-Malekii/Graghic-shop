<?php

namespace App\Http\Requests\Admin\Users;

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
        // آی‌دی کاربر فعلی از Route Model Binding
        $userId = $this->route('user')->id;

        return [
            'name'   => ['required', 'string', 'min:3', 'max:255'],
            'email'  => [
                'required', 'email', 'max:255',
                Rule::unique('users','email')->ignore($userId),
            ],
            'mobile' => ['required', 'regex:/^09[0-9]{9}$/'],
            'role'   => ['required', Rule::in(['admin','user'])],
            // در ویرایش اگر پسورد را تغییر ندهند خالی بماند:
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
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
