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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'post_id' => 'required|exists:posts,id',
            'typeVote' => 'required|in:standard,etoiles,pouces',
            'auteur_id' => 'nullable|exists:users,id',
            'question' => 'required|string|max:255',
        ];
        if ($this->input('typeVote') === 'standard') {
            $rules['poll_options'] = 'required|array|min:2';
            $rules['poll_options.*'] = 'required|string|max:255';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'poll_options.required' => 'Vous devez spécifier au moins deux options pour le sondage.',
            'poll_options.min' => 'Le sondage doit avoir au moins :min options.',
            'poll_options.*.required' => 'Le texte de chaque option est obligatoire.',
            'question.required' => 'La question du sondage est obligatoire.',
        ];
    }
}
