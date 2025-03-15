<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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

    public function messages()
    {
        return [
            'title.required' => 'The task title is required.',
            'status.required' => 'The task status is required.',
            'status.in' => 'The status must be one of the following values: Open, In Progress, Completed, Rejected.',
            'assigned_user_id.exists' => 'The assigned user must be valid.',
            'building_id.required' => 'The task must be linked to a valid building.',
        ];
    }

}
