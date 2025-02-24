<?php

namespace App\Http\Requests\History;

use Illuminate\Foundation\Http\FormRequest;

class CreateHistoryRequest extends FormRequest
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
            'file_id' => 'required|integer|exists:files,id',
            'status' => 'required|string|in:reserve,create,cancle,edit',
        ];
    }
}
