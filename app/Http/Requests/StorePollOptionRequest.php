<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePollOptionRequest extends FormRequest
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
            'poll_id' => 'required|exists:polls,id',
            'text' => 'required|string|max:255',
            'position' => 'integer|min:0'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'poll_id.required' => 'L\'ID du sondage est requis.',
            'poll_id.exists' => 'Le sondage spécifié n\'existe pas.',
            'text.required' => 'Le texte de l\'option est requis.',
            'text.max' => 'Le texte de l\'option ne doit pas dépasser 255 caractères.',
            'position.integer' => 'La position doit être un nombre entier.',
            'position.min' => 'La position doit être un nombre positif.'
        ];
    }
}
