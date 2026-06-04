<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'registradopor' => $this->registradopor
                ?? auth()->user()?->name
                ?? 'Sistema',
        ]);
    }

    public function rules(): array
    {
        if (! $this->isMethod('post') && ! $this->isMethod('put') && ! $this->isMethod('patch')) {
            return [];
        }

        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');

        $rules = [
            'nombre' => $isUpdate
                ? ValidationRules::lettersOnlyForRequest($this, 'nombre', Cliente::class, 'cliente')
                : ValidationRules::lettersOnly(),
            'telefono' => ValidationRules::phone(),
            'email' => ['required', 'string', 'email', 'max:255'],
            'direccion' => $isUpdate
                ? ValidationRules::addressForRequest($this, 'direccion', Cliente::class, 'cliente')
                : ValidationRules::address(),
            'estado' => ['nullable', 'string', 'max:50'],
            'registradopor' => ['required', 'string', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            $rules['email'][] = 'unique:clientes,email';
        }

        if ($isUpdate) {
            $rules['email'][] = 'unique:clientes,email,'.$this->route('cliente');
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return array_merge(
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.max' => 'El nombre no puede superar 255 caracteres.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.max' => 'El teléfono no puede superar 50 caracteres.',
                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'El correo debe tener un formato válido.',
                'email.unique' => 'Este correo ya está registrado.',
                'direccion.required' => 'La dirección es obligatoria.',
                'direccion.max' => 'La dirección no puede superar 255 caracteres.',
            ],
            ValidationRules::letterRegexMessage('nombre', 'El nombre'),
            ValidationRules::addressRegexMessage('direccion', 'La dirección'),
            ValidationRules::phoneRegexMessage('telefono', 'El teléfono'),
        );
    }
}
