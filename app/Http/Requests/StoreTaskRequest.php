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
}
