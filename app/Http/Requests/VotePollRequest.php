<?php

namespace App\Http\Requests\Poll;

use Illuminate\Foundation\Http\FormRequest;

class VotePollRequest extends FormRequest
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
            'vote_value' => 'required|integer|min:0|max:5',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'vote_value.required' => 'La valeur du vote est requise',
            'vote_value.integer' => 'La valeur du vote doit être un nombre entier',
            'vote_value.min' => 'La valeur du vote ne peut pas être inférieure à 0',
            'vote_value.max' => 'La valeur du vote ne peut pas être supérieure à 5',
        ];
    }
}