<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contenu' => 'required|string|min:1|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'contenu.required' => 'Le contenu de la réponse est requis',
            'contenu.min' => 'La réponse doit contenir au moins 1 caractère',
            'contenu.max' => 'La réponse ne peut pas dépasser 1000 caractères',
        ];
    }
}