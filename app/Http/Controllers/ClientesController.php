<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        try {
            $data = $request->validated();
            $data['foto'] = Cliente::getRandomFoto();
            Cliente::create($data);

            return redirect()
                ->route('clientes.index')
                ->with(
                    'successMsg',
                    'El cliente se registró exitosamente'
                );
        } catch (QueryException $e) {
            Log::error('Error al crear cliente: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo guardar el cliente. Verifique los datos e intente de nuevo.']);
        }
    }

    public function show(string $id)
    {
        $cliente = Cliente::with('tickets')->findOrFail($id);

        return view('clientes.show', compact('cliente'));
    }

    public function edit(string $id)
    {
        $cliente = Cliente::findOrFail($id);

        return view(
            'clientes.edit',
            compact('cliente')
        );
    }

    public function update(ClienteRequest $request, string $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            $cliente->update($request->validated());

            return redirect()
                ->route('clientes.index')
                ->with(
                    'successMsg',
                    'El cliente se actualizó exitosamente'
                );
        } catch (QueryException $e) {
            Log::error('Error al actualizar cliente: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo actualizar el cliente. Verifique los datos e intente de nuevo.']);
        }
    }

    public function destroy(Cliente $cliente)
    {
        try {

            $cliente->delete();

            return redirect()
                ->route('clientes.index')
                ->with(
                    'successMsg',
                    'El registro se eliminó exitosamente'
                );

        } catch (QueryException $e) {

            Log::error(
                'Error al eliminar el cliente: '
                . $e->getMessage()
            );

            return redirect()
                ->route('clientes.index')
                ->withErrors(
                    'El registro tiene información relacionada.'
                );

        } catch (Exception $e) {

            Log::error(
                'Error inesperado: '
                . $e->getMessage()
            );

            return redirect()
                ->route('clientes.index')
                ->withErrors(
                    'Ocurrió un error inesperado.'
                );
        }
    }

    public function cambioestadocliente(Request $request)
    {
        $cliente = Cliente::find($request->id);

        if ($cliente) {
            $cliente->estado = $request->estado;
            $cliente->save();
        }
    }

    public function selectClientePdf()
    {
        $clientes = Cliente::paginate(10);
        return view('clientes.select-pdf', compact('clientes'));
    }

    public function exportPdf(string $id)
    {
        // Si es 'all', genera PDF de todos los clientes
        if ($id === 'all') {
            $clientes = Cliente::with('tickets')->get();
            $pdf = Pdf::loadView('clientes.pdf-todos', compact('clientes'));
            return $pdf->download('clientes_listado_completo.pdf');
        }

        // Si no, es un cliente específico
        $cliente = Cliente::with('tickets')->findOrFail($id);
        $pdf = Pdf::loadView('clientes.pdf-detalle', compact('cliente'));
        return $pdf->download("cliente_{$cliente->nombre}_{$id}.pdf");
    }

    public function viewPdf(string $id)
    {
        $cliente = Cliente::with('tickets')->findOrFail($id);
        $pdf = Pdf::loadView('clientes.pdf-detalle', compact('cliente'));
        return $pdf->stream("cliente_{$cliente->nombre}_{$id}.pdf");
    }

    public function exportExcel(string $id)
    {
        if ($id === 'all') {
            $clientes = Cliente::all();
            $filename = 'clientes_listado_completo.xlsx';
        } else {
            $cliente  = Cliente::findOrFail($id);
            $clientes = collect([$cliente]);
            $filename = 'cliente_' . str_replace(' ', '_', $cliente->nombre) . "_{$id}.xlsx";
        }

        // Limpiar cualquier output buffer activo para evitar contaminación del binario
        while (ob_get_level()) {
            ob_end_clean();
        }

        return Excel::download(new ClientesExport($clientes), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }
}
