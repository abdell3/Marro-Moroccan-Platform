<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollRequest extends FormRequest
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
            'post_id' => 'required|exists:posts,id',
            'auteur_id' => 'sometimes|exists:users,id',
            'typeVote' => 'required|string|in:standard,etoiles,pouces',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => 'Le post est requis',
            'post_id.exists' => 'Le post sélectionné n\'existe pas',
            'auteur_id.exists' => 'L\'auteur sélectionné n\'existe pas',
            'typeVote.required' => 'Le type de vote est requis',
            'typeVote.in' => 'Le type de vote doit être standard, etoiles ou pouces',
        ];
    }
}
