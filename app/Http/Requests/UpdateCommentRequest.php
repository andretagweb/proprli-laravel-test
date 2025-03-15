<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'The comment content is required.',
            'content.max' => 'The comment cannot exceed 500 characters.',
        ];
    }
}
