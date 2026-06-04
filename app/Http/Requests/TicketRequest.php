<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->usuario_asignado_id === '' || $this->usuario_asignado_id === null) {
            $this->merge(['usuario_asignado_id' => null]);
        }

        if ($this->isMethod('post')) {
            $this->merge([
                'registrado_por' => auth()->user()?->name ?? 'Sistema',
            ]);
        }
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'titulo'              => ValidationRules::lettersOnly(),
                'cliente_id'          => ['required', 'exists:clientes,id'],
                'descripcion'         => ValidationRules::text(),
                'usuario_asignado_id' => ['nullable', 'exists:users,id'],
                'estado'              => ['nullable'],
                'registrado_por'      => ['nullable', 'string', 'max:255'],
                'imagen'              => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120'],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'titulo'              => ValidationRules::lettersOnlyForRequest($this, 'titulo', Ticket::class, 'ticket'),
                'cliente_id'          => ['required', 'exists:clientes,id'],
                'descripcion'         => ValidationRules::textForRequest($this, 'descripcion', Ticket::class, 'ticket'),
                'usuario_asignado_id' => ['nullable', 'exists:users,id'],
                'estado'              => ['nullable'],
                'imagen'              => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120'],
                'eliminar_imagen'     => ['nullable', 'in:1'],
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
                'titulo.required'             => 'El título es obligatorio.',
                'titulo.max'                  => 'El título no puede superar 255 caracteres.',
                'cliente_id.required'         => 'Debe seleccionar un cliente.',
                'cliente_id.exists'           => 'El cliente seleccionado no es válido.',
                'descripcion.required'        => 'La descripción es obligatoria.',
                'descripcion.max'             => 'La descripción es demasiado larga.',
                'usuario_asignado_id.exists'  => 'El usuario asignado no es válido.',
                'imagen.image'                => 'El archivo debe ser una imagen.',
                'imagen.mimes'                => 'La imagen debe ser JPG, PNG, GIF o WEBP.',
                'imagen.max'                  => 'La imagen no puede superar los 5MB.',
            ],
            ValidationRules::letterRegexMessage('titulo', 'El título'),
            ValidationRules::textRegexMessage('descripcion', 'La descripción'),
        );
    }
}
