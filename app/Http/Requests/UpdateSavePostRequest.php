<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSavePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $savepost = $this->route('savepost');
        return auth()->check() && auth()->id() == $savepost->user_id;
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
            'user_id' => 'sometimes|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.exists' => 'Le post sélectionné n\'existe pas',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas',
        ];
    }
}
