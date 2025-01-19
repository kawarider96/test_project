<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'project_name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'project_name.required' => 'A projekt neve kötelező!',
            'project_name.max' => 'A projekt neve nem lehet hosszabb 255 karakternél.',
        ];
    }
}
