<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
            'contenu' => 'required|string|min:1|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => 'Le post est requis',
            'post_id.exists' => 'Le post sélectionné n\'existe pas',
            'parent_id.exists' => 'Le commentaire parent n\'existe pas',
            'contenu.required' => 'Le contenu du commentaire est requis',
            'contenu.min' => 'Le commentaire doit contenir au moins 1 caractère',
            'contenu.max' => 'Le commentaire ne peut pas dépasser 1000 caractères',
        ];
    }
}
