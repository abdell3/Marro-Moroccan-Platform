<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'community_id' => 'required|exists:communities,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'content.required' => 'Le contenu est obligatoire',
            'content.min' => 'Le contenu doit avoir au moins 10 caractères',
            'community_id.required' => 'Veuillez sélectionner une communauté',
            'community_id.exists' => 'Cette communauté n\'existe pas',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
