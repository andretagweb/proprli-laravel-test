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
}
