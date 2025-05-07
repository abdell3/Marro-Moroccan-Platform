<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\Guard;


class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_name' => 'required|string|max:255|unique:roles,role_name',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'role_name.required' => 'Le nom du rôle est obligatoire',
            'role_name.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'role_name.unique' => 'Ce rôle existe déjà',
            'description.max' => 'La description ne peut pas dépasser 255 caractères',
            'permissions.array' => 'Les permissions doivent être un tableau',
            'permissions.*.exists' => 'Une des permissions sélectionnées n\'existe pas',
        ];
    }
}
