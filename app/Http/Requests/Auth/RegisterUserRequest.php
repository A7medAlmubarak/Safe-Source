<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name'      => "required|string|max:255|regex:/^[A-Za-z0-9 _]+$/",
            'email'     => "required|email|max:255|unique:users,email",
            'password'  => "required|string|min:6|max:255",
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'email.required' => 'An email is required',
            'email.unique' => 'This email is already taken',
            'password.required' => 'A password is required',
            'password.min' => 'The password must be at least 8 characters',
        ];
    }

}
