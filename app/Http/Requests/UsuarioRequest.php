<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name' => ValidationRules::lettersOnly(),
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
                'tipo_usuario_id' => ['required', 'exists:tipo_usuarios,id'],
                'estado' => ['nullable'],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name' => ValidationRules::lettersOnlyForRequest($this, 'name', User::class, 'usuario'),
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->route('usuario')],
                'password' => ['nullable', 'string', 'min:8'],
                'tipo_usuario_id' => ['required', 'exists:tipo_usuarios,id'],
                'estado' => ['nullable'],
            ];
        }

        return [];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return array_merge(
            [
                'name.required' => 'El nombre es obligatorio.',
                'name.max' => 'El nombre no puede superar 255 caracteres.',
                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'El correo debe tener un formato válido.',
                'email.unique' => 'Este correo ya está registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'tipo_usuario_id.required' => 'Debe seleccionar un tipo de usuario.',
                'tipo_usuario_id.exists' => 'El tipo de usuario seleccionado no es válido.',
            ],
            ValidationRules::letterRegexMessage('name', 'El nombre'),
        );
    }
}
