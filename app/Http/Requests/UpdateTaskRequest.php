<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:Open,In Progress,Completed,Rejected',
            'assigned_user_id' => 'nullable|exists:users,id',
            'building_id' => 'nullable|exists:buildings,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The task title is required.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'status.required' => 'The task status is required.',
            'status.in' => 'The status must be one of the following: Open, In Progress, Completed, Rejected.',
            'assigned_user_id.exists' => 'The assigned user does not exist in the database.',
            'building_id.exists' => 'The specified building does not exist in the database.',
        ];
    }
}
