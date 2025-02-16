<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class CreateFileRequest extends FormRequest
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
            'file' => 'required|file|max:10240', // 10MB Max
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'A file is required',
            'file.file' => 'The uploaded file is not valid',
            'file.max' => 'The file size must not exceed 10MB',
        ];
    }

}
