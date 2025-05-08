<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePollRequest extends FormRequest
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
            'post_id' => 'sometimes|exists:posts,id',
            'auteur_id' => 'sometimes|exists:users,id',
            'typeVote' => 'sometimes|string|in:standard,etoiles,pouces',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.exists' => 'Le post sélectionné n\'existe pas',
            'auteur_id.exists' => 'L\'auteur sélectionné n\'existe pas',
            'typeVote.in' => 'Le type de vote doit être standard, etoiles ou pouces',
        ];
    }
}
