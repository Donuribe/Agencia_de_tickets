<?php

namespace App\Http\Controllers;

use App\Exports\ComentariosExport;
use App\Models\Comentario;
use App\Models\Ticket;
use App\Models\User;
use App\Support\ValidationRules;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ComentariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comentarios = Comentario::with(['ticket', 'usuario'])->get();

        return view('comentarios.index', compact('comentarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $comentario = Comentario::findOrFail($id);
        $tickets = Ticket::all();
        $usuarios = User::all();

        return view('comentarios.edit', compact('comentario', 'tickets', 'usuarios'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $comentario = Comentario::findOrFail($id);

        $validated = $request->validate([
            'mensaje' => ValidationRules::text(),
            'ticket_id' => ['required', 'exists:tickets,id'],
            'usuario_id' => ['required', 'exists:users,id'],
            'estado' => ['nullable', 'string', 'max:50'],
        ], array_merge([
            'mensaje.required' => 'El mensaje es obligatorio.',
            'ticket_id.required' => 'Debe seleccionar un ticket.',
            'ticket_id.exists' => 'El ticket seleccionado no es válido.',
            'usuario_id.required' => 'Debe seleccionar un usuario.',
            'usuario_id.exists' => 'El usuario seleccionado no es válido.',
        ], ValidationRules::textRegexMessage('mensaje', 'El mensaje')));

        try {
            $comentario->update($validated);

            return redirect()
                ->route('comentarios.index')
                ->with('successMsg', 'El comentario se actualizó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al actualizar comentario: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo actualizar el comentario. Verifique los datos e intente de nuevo.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {

        try {

            $comentario->delete();

            return redirect()->route('comentarios.index')->with('successMsg', 'El comentario se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar el comentario: '.$e->getMessage());

            return redirect()->route('comentarios.index')->withErrors('El comentario que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar el comentario: '.$e->getMessage());

            return redirect()->route('comentarios.index')->withErrors('Ocurrió un error inesperado al eliminar el comentario. Comuníquese con el Administrador');
        }
    }

    public function cambioestadocomentario(Request $request)
    {
        $comentarios = Comentario::find($request->id);
        $comentarios->estado = $request->estado;
        $comentarios->save();
    }

    public function selectComentarioPdf()
    {
        $comentarios = Comentario::with(['ticket', 'usuario'])->orderBy('fecha', 'desc')->paginate(10);
        return view('comentarios.select-pdf', compact('comentarios'));
    }

    public function exportPdf($id = null)
    {
        if ($id === 'all' || $id === null) {
            $comentarios = Comentario::with(['ticket', 'usuario'])->orderBy('fecha', 'desc')->get();
            $pdf = Pdf::loadView('comentarios.pdf-reporte', compact('comentarios'));
            return $pdf->download('comentarios_reporte.pdf');
        }

        // Si es un ID específico
        $comentario = Comentario::with(['ticket', 'usuario'])->findOrFail($id);
        $pdf = Pdf::loadView('comentarios.pdf-individual', compact('comentario'));
        return $pdf->download("comentario_{$comentario->id}.pdf");
    }

    public function viewPdf($id)
    {
        $comentario = Comentario::with(['ticket', 'usuario'])->findOrFail($id);
        $pdf = Pdf::loadView('comentarios.pdf-individual', compact('comentario'));
        return $pdf->stream("comentario_{$comentario->id}.pdf");
    }

    public function exportExcel($id = null)
    {
        if ($id === 'all' || $id === null) {
            $comentarios = Comentario::with(['ticket', 'usuario.tipoUsuario'])->orderBy('fecha', 'desc')->get();
            $filename    = 'comentarios_reporte.xlsx';
        } else {
            $comentario  = Comentario::with(['ticket', 'usuario.tipoUsuario'])->findOrFail($id);
            $comentarios = collect([$comentario]);
            $filename    = "comentario_{$id}.xlsx";
        }

        // Limpiar output buffer para evitar contaminación del binario XLSX
        while (ob_get_level()) {
            ob_end_clean();
        }

        return Excel::download(new ComentariosExport($comentarios), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }
}
