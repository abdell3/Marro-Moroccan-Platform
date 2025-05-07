<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Validation\Rule;


class UpdateTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermission('edit_tags');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tagId = $this->route('tag')->id;
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags')->ignore($tagId),
            ],
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du tag est obligatoire',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères',
            'title.unique' => 'Ce tag existe déjà',
            'description.max' => 'La description ne peut pas dépasser 255 caractères',
        ];
    }
}
