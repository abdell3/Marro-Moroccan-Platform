<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Guard;

class StorePostRequest extends FormRequest
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
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'typeContenu' => 'nullable|string',
            'media_path' => 'nullable|string',
            'media_type' => 'nullable|string',
            'community_id' => 'required|exists:communities,id',
            'media' => 'nullable|file|max:5120', 
        ];
    }
    
    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'community_id.required' => 'La communauté est obligatoire',
            'community_id.exists' => 'Cette communauté n\'existe pas',
            'media.max' => 'Le fichier est trop volumineux (max 5 Mo)',
        ];
    }
}
