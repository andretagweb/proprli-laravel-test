<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,In Progress,Completed,Rejected',
            'assigned_user_id' => 'nullable|exists:users,id',
            'building_id' => 'required|exists:buildings,id',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The task title is required.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'status.required' => 'The task status is required.',
            'status.in' => 'The status must be one of the following: Open, In Progress, Completed, Rejected.',
            'assigned_user_id.exists' => 'The assigned user does not exist in the database.',
            'building_id.required' => 'The building ID is required.',
            'building_id.exists' => 'The specified building does not exist in the database.',
        ];
    }
}
