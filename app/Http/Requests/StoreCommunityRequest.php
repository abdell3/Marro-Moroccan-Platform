<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommunityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'theme_name' => 'required|string|max:255|unique:communities',
            'description' => 'nullable|string|max:1000',
            'rules' => 'nullable|string|max:2000',
            'icon_file' => 'nullable|image|max:2048',
            'creator_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'theme_name.required' => 'Le nom de la communauté est obligatoire',
            'theme_name.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'theme_name.unique' => 'Cette communauté existe déjà',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères',
            'rules.max' => 'Les règles ne peuvent pas dépasser 2000 caractères',
            'icon_file.image' => 'Le fichier doit être une image',
            'icon_file.max' => 'L\'image ne doit pas dépasser 2Mo',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'creator_id' => auth()->id(),
        ]);
    }
}
