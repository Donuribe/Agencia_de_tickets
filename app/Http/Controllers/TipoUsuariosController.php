<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoUsuarioRequest;
use App\Models\TipoUsuario;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoUsuariosController extends Controller
{
    public function index()
    {
        $tipoUsuarios = TipoUsuario::all();

        return view(
            'tipousuarios.index',
            compact('tipoUsuarios')
        );
    }

    public function create()
    {
        return view('tipousuarios.create');
    }

    public function store(TipoUsuarioRequest $request)
    {
        try {
            TipoUsuario::create($request->validated());

            return redirect()
                ->route('tipousuarios.index')
                ->with(
                    'successMsg',
                    'El tipo de usuario se registró exitosamente'
                );
        } catch (QueryException $e) {
            Log::error('Error al crear tipo de usuario: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo guardar el tipo de usuario. Verifique los datos e intente de nuevo.']);
        }
    }

    public function show(string $id)
    {
        $tipoUsuario = TipoUsuario::with('usuarios')->findOrFail($id);

        return view(
            'tipousuarios.show',
            compact('tipoUsuario')
        );
    }

    public function edit(string $id)
    {
        $tipoUsuario = TipoUsuario::findOrFail($id);

        return view(
            'tipousuarios.edit',
            compact('tipoUsuario')
        );
    }

    public function update(TipoUsuarioRequest $request, string $id)
    {
        try {
            $tipoUsuario = TipoUsuario::findOrFail($id);

            $tipoUsuario->update($request->validated());

            return redirect()
                ->route('tipousuarios.index')
                ->with(
                    'successMsg',
                    'El tipo de usuario se actualizó exitosamente'
                );
        } catch (QueryException $e) {
            Log::error('Error al actualizar tipo de usuario: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo actualizar el tipo de usuario. Verifique los datos e intente de nuevo.']);
        }
    }

    public function destroy(TipoUsuario $tipousuario)
    {
        try {

            $tipousuario->delete();

            return redirect()
                ->route('tipousuarios.index')
                ->with(
                    'successMsg',
                    'El registro se eliminó exitosamente'
                );

        } catch (QueryException $e) {

            Log::error(
                'Error al eliminar tipo de usuario: '
                . $e->getMessage()
            );

            return redirect()
                ->route('tipousuarios.index')
                ->withErrors(
                    'El registro tiene información relacionada.'
                );

        } catch (Exception $e) {

            Log::error(
                'Error inesperado: '
                . $e->getMessage()
            );

            return redirect()
                ->route('tipousuarios.index')
                ->withErrors(
                    'Ocurrió un error inesperado.'
                );
        }
    }

    public function cambioestadotipousuarios(Request $request)
    {
        $tipoUsuario = TipoUsuario::find($request->id);

        if ($tipoUsuario) {

            $tipoUsuario->estado = $request->estado;

            $tipoUsuario->save();
        }
    }
}
