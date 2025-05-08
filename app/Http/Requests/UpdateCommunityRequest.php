<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommunityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $community = $this->route('community');
        return auth()->check() && auth()->id() == $community->creator_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $communityId = $this->route('community')->id;
        return [
            'theme_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('communities')->ignore($communityId),
            ],
            'description' => 'nullable|string|max:1000',
            'rules' => 'nullable|string|max:2000',
            'icon_file' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'theme_name.required' => 'Le nom de la communauté est obligatoire',
            'theme_name.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'theme_name.unique' => 'Cette communauté existe déjà',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères',
            'rules.max' => 'Les règles ne peuvent pas dépasser 2000 caractères',
            'icon_file.image' => 'Le fichier doit être une image',
            'icon_file.max' => 'L\'image ne doit pas dépasser 2Mo',
        ];
    }
}
