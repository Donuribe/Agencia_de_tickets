<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\TipoUsuario;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class UsuariosController extends Controller
{
    public function index()
    {
        $usuarios = User::with('tipoUsuario')->get();

        return view(
            'usuarios.index',
            compact('usuarios')
        );
    }

    public function create()
    {
        $tipoUsuarios = TipoUsuario::all();

        return view(
            'usuarios.create',
            compact('tipoUsuarios')
        );
    }

    public function store(UsuarioRequest $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'estado' => $request->estado ?? 1,
            ];

            if (Schema::hasColumn('users', 'tipo_usuario_id')) {
                $data['tipo_usuario_id'] = $request->tipo_usuario_id;
            }

            User::create($data);

            return redirect()
                ->route('usuarios.index')
                ->with(
                    'successMsg',
                    'El usuario se registró exitosamente'
                );
        } catch (QueryException $e) {
            Log::error('Error al crear usuario: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo guardar el usuario. Verifique los datos e intente de nuevo.']);
        }
    }

    public function show(string $id)
    {
        $usuario = User::with('tipoUsuario')->findOrFail($id);

        return view(
            'usuarios.show',
            compact('usuario')
        );
    }

    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);

        $tipoUsuarios = TipoUsuario::all();

        return view(
            'usuarios.edit',
            compact(
                'usuario',
                'tipoUsuarios'
            )
        );
    }

    public function update(UsuarioRequest $request, string $id)
    {
        try {
            $usuario = User::findOrFail($id);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'estado' => $request->estado,
            ];

            if (Schema::hasColumn('users', 'tipo_usuario_id')) {
                $data['tipo_usuario_id'] = $request->tipo_usuario_id;
            }

            if ($request->filled('password')) {
                $data['password'] = $request->password;
            }

            $usuario->update($data);

            return redirect()
                ->route('usuarios.index')
                ->with(
                    'successMsg',
                    'El usuario se actualizó exitosamente'
                );
        } catch (QueryException $e) {
            Log::error('Error al actualizar usuario: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo actualizar el usuario. Verifique los datos e intente de nuevo.']);
        }
    }

    public function destroy(User $usuario)
    {
        try {

            $usuario->delete();

            return redirect()
                ->route('usuarios.index')
                ->with(
                    'successMsg',
                    'El usuario se eliminó exitosamente'
                );

        } catch (QueryException $e) {

            Log::error(
                'Error al eliminar el usuario: '
                . $e->getMessage()
            );

            return redirect()
                ->route('usuarios.index')
                ->withErrors(
                    'El usuario tiene información relacionada.'
                );

        } catch (Exception $e) {

            Log::error(
                'Error inesperado: '
                . $e->getMessage()
            );

            return redirect()
                ->route('usuarios.index')
                ->withErrors(
                    'Ocurrió un error inesperado.'
                );
        }
    }

    public function cambioestadousuario(Request $request)
    {
        $usuario = User::find($request->id);

        if (! $usuario) {

            return response()->json([
                'mensaje' => 'Usuario no encontrado',
            ], 404);
        }

        $usuario->estado = $request->estado;

        $usuario->save();

        return response()->json([
            'mensaje' => 'Estado actualizado correctamente',
        ]);
    }
}
