<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The building name is required.',
            'name.string' => 'The building name must be a valid text.',
            'name.max' => 'The building name cannot exceed 255 characters.',
            'address.string' => 'The address must be a valid text.',
        ];
    }

}
