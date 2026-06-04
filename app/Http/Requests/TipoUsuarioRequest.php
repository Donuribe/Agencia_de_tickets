<?php

namespace App\Http\Requests;

use App\Models\TipoUsuario;
use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class TipoUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if (! $this->isMethod('post') && ! $this->isMethod('put') && ! $this->isMethod('patch')) {
            return [];
        }

        $nombreTipoRules = $this->isMethod('post')
            ? ValidationRules::lettersOnly()
            : ValidationRules::lettersOnlyForRequest($this, 'nombre_tipo', TipoUsuario::class, 'tipousuario');

        if ($this->isMethod('post')) {
            $nombreTipoRules[] = 'unique:tipo_usuarios,nombre_tipo';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $nombreTipoRules[] = 'unique:tipo_usuarios,nombre_tipo,'.$this->route('tipousuario');
        }

        return [
            'nombre_tipo' => $nombreTipoRules,
            'estado' => ['nullable'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return array_merge(
            [
                'nombre_tipo.required' => 'El nombre del tipo es obligatorio.',
                'nombre_tipo.max' => 'El nombre no puede superar 255 caracteres.',
                'nombre_tipo.unique' => 'Este tipo de usuario ya existe.',
            ],
            ValidationRules::letterRegexMessage('nombre_tipo', 'El nombre del tipo'),
        );
    }
}
