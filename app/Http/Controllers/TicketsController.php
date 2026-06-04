<?php

namespace App\Http\Controllers;

use App\Exports\TicketsExport;
use App\Http\Requests\TicketRequest;
use App\Models\Cliente;
use App\Models\Comentario;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class TicketsController extends Controller
{
    public function index(): View
    {
        $tickets = Ticket::with(['cliente', 'usuarioAsignado'])->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create(): View
    {
        $clientes = Cliente::all();
        $usuarios = User::all();

        return view('tickets.create', compact('clientes', 'usuarios'));
    }

    public function store(TicketRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['estado']        = $data['estado'] ?? 1;
            $data['registrado_por'] = auth()->user()?->name ?? 'Sistema';
            $data['user_id']       = auth()->id();

            // Guardar imagen si se subió
            if ($request->hasFile('imagen')) {
                $data['imagen'] = $request->file('imagen')
                    ->store('uploads/tickets', 'public');
                // Guardar solo el nombre relativo
                $data['imagen'] = basename($data['imagen']);
            } else {
                unset($data['imagen']);
            }

            Ticket::create($data);

            return redirect()
                ->route('tickets.index')
                ->with('successMsg', 'El ticket se registró exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al crear ticket: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo guardar el ticket. Verifique los datos e intente de nuevo.']);
        }
    }

    public function show(string $id): View
    {
        $ticket = Ticket::with(['cliente', 'usuarioAsignado', 'comentarios.usuario', 'user'])->findOrFail($id);

        // Generar historial ficticio random de atención
        $historial = $this->generarHistorialFicticio($ticket);

        return view('tickets.show', compact('ticket', 'historial'));
    }

    /**
     * Genera un historial ficticio de atención para el ticket.
     * Simula traslados entre agentes/soporte y resolución final del cliente.
     */
    private function generarHistorialFicticio(Ticket $ticket): array
    {
        // Usar el ID del ticket como semilla para que sea consistente (no cambie al recargar)
        srand($ticket->id * 7919);

        // Usar los usuarios reales del sistema con sus roles
        $usuariosDB = User::with('tipoUsuario')
            ->whereNotNull('tipo_usuario_id')
            ->where('estado', 1)
            ->get(['id', 'name', 'tipo_usuario_id']);

        // Convertir a array con nombre y rol
        $nombresAgentes = $usuariosDB->map(function ($u) {
            return [
                'nombre' => $u->name,
                'rol'    => $u->tipoUsuario->nombre_tipo ?? 'Soporte',
            ];
        })->values()->toArray();

        // Fallback si no hay usuarios
        if (empty($nombresAgentes)) {
            $nombresAgentes = [
                ['nombre' => 'Soporte Técnico', 'rol' => 'Soporte'],
            ];
        }

        $mensajesRecepcion = [
            'Ticket recibido y registrado en el sistema. Procedo a revisar el problema reportado.',
            'He recibido la solicitud. Voy a analizar el inconveniente para determinar el origen.',
            'Ticket asignado a mi usuario. Inicio la revisión del problema de inmediato.',
            'Recibido. Comenzaré el diagnóstico técnico del problema reportado.',
        ];

        $mensajesDiagnostico = [
            'Tras la revisión inicial, el problema parece estar relacionado con la configuración del sistema. Necesito apoyo de otro especialista.',
            'He diagnosticado el inconveniente. Requiere intervención de nivel 2. Transfiero el caso.',
            'El análisis indica que el problema es de mayor complejidad. Escalo a soporte especializado.',
            'Revisado el caso, determiné que necesita atención de un técnico con perfil diferente. Procedo a trasladar.',
        ];

        $mensajesTraslado = [
            'Recibí el caso trasladado. Revisando el historial previo para continuar la atención.',
            'Caso transferido a mi gestión. Aplicaré los procedimientos estándar para este tipo de incidencia.',
            'Recibo el ticket. Con base en la información previa, procedo a aplicar una solución alternativa.',
            'Traslado recibido. Voy a trabajar directamente en el sistema del cliente para resolver el inconveniente.',
        ];

        $mensajesSolucion = [
            'Aplicada la corrección en el módulo afectado. Se realizaron pruebas y el sistema responde correctamente.',
            'El problema fue resuelto mediante la actualización de los parámetros de configuración. Todo funciona con normalidad.',
            'Se identificó y corrigió el error en la base de datos. El servicio ha sido restaurado exitosamente.',
            'Solución implementada: se reinstalaron los componentes afectados y se validó el correcto funcionamiento.',
        ];

        $mensajesCierreOk = [
            'Confirmo que el problema ya está resuelto. Todo funciona perfectamente. ¡Muchas gracias por la atención!',
            'El inconveniente fue solucionado. El sistema ya opera con normalidad. Muy satisfecho con el servicio.',
            'Verificado de mi parte, el problema está corregido. Gracias al equipo de soporte por la pronta respuesta.',
            'Todo en orden. El sistema funciona bien ahora. Agradezco la atención recibida.',
        ];

        $mensajesCierreNok = [
            'El problema persiste. Sigo teniendo el mismo error que reporté inicialmente. Por favor, revisar nuevamente.',
            'Lamentablemente el inconveniente no está resuelto. El sistema continúa fallando en el mismo punto.',
            'Aún no funciona correctamente. El error aparece de nuevo cuando intento acceder al módulo afectado.',
            'El problema no fue solucionado completamente. Hay situaciones específicas donde el fallo persiste.',
        ];

        $historial = [];
        $totalAgentes = count($nombresAgentes);
        $numTraslados = min(rand(1, 3), $totalAgentes - 1);

        // Seleccionar agentes sin repetir
        $indices = range(0, $totalAgentes - 1);
        shuffle($indices);
        $agentesSeleccionados = array_slice($indices, 0, $numTraslados + 1);

        // Fecha base desde la creación del ticket
        $fechaBase = $ticket->fecha_creacion
            ? \Carbon\Carbon::parse($ticket->fecha_creacion)
            : \Carbon\Carbon::now()->subDays(5);

        $minutosAcumulados = 0;

        // 1. Recepción inicial
        $primerAgente = $nombresAgentes[$agentesSeleccionados[0]];
        $historial[] = [
            'autor'  => $primerAgente['nombre'],
            'rol'    => $primerAgente['rol'],
            'tipo'   => 'recepcion',
            'msg'    => $mensajesRecepcion[array_rand($mensajesRecepcion)],
            'fecha'  => $fechaBase->copy()->addMinutes($minutosAcumulados)->format('d/m/Y H:i'),
            'icono'  => 'fas fa-inbox',
            'color'  => 'info',
        ];

        // 2. Diagnóstico
        $minutosAcumulados += rand(15, 60);
        $historial[] = [
            'autor'  => $primerAgente['nombre'],
            'rol'    => $primerAgente['rol'],
            'tipo'   => 'diagnostico',
            'msg'    => $mensajesDiagnostico[array_rand($mensajesDiagnostico)],
            'fecha'  => $fechaBase->copy()->addMinutes($minutosAcumulados)->format('d/m/Y H:i'),
            'icono'  => 'fas fa-search',
            'color'  => 'warning',
        ];

        // 3. Traslados entre agentes
        for ($i = 1; $i <= $numTraslados; $i++) {
            $minutosAcumulados += rand(30, 120);
            $agenteActual = $nombresAgentes[$agentesSeleccionados[$i]];
            $historial[] = [
                'autor'  => $agenteActual['nombre'],
                'rol'    => $agenteActual['rol'],
                'tipo'   => 'traslado',
                'msg'    => $mensajesTraslado[array_rand($mensajesTraslado)],
                'fecha'  => $fechaBase->copy()->addMinutes($minutosAcumulados)->format('d/m/Y H:i'),
                'icono'  => 'fas fa-exchange-alt',
                'color'  => 'secondary',
            ];
        }

        // 4. Solución aplicada (último agente)
        $minutosAcumulados += rand(20, 90);
        $ultimoAgente = $nombresAgentes[$agentesSeleccionados[$numTraslados]];
        $historial[] = [
            'autor'  => $ultimoAgente['nombre'],
            'rol'    => $ultimoAgente['rol'],
            'tipo'   => 'solucion',
            'msg'    => $mensajesSolucion[array_rand($mensajesSolucion)],
            'fecha'  => $fechaBase->copy()->addMinutes($minutosAcumulados)->format('d/m/Y H:i'),
            'icono'  => 'fas fa-check-circle',
            'color'  => 'success',
        ];

        // 5. Respuesta final del cliente (random: resuelto o no)
        $minutosAcumulados += rand(60, 480);
        $resuelto    = (bool) rand(0, 1);
        $nombreCliente = $ticket->cliente->nombre ?? 'Cliente';
        $historial[] = [
            'autor'    => $nombreCliente,
            'rol'      => 'Cliente',
            'tipo'     => $resuelto ? 'cierre_ok' : 'cierre_nok',
            'msg'      => $resuelto
                            ? $mensajesCierreOk[array_rand($mensajesCierreOk)]
                            : $mensajesCierreNok[array_rand($mensajesCierreNok)],
            'fecha'    => $fechaBase->copy()->addMinutes($minutosAcumulados)->format('d/m/Y H:i'),
            'icono'    => $resuelto ? 'fas fa-thumbs-up' : 'fas fa-thumbs-down',
            'color'    => $resuelto ? 'success' : 'danger',
            'resuelto' => $resuelto,
        ];

        srand(); // resetear semilla

        return $historial;
    }

    public function edit(string $id): View
    {
        $ticket = Ticket::findOrFail($id);
        $clientes = Cliente::all();
        $usuarios = User::all();

        return view('tickets.edit', compact('ticket', 'clientes', 'usuarios'));
    }

    public function update(TicketRequest $request, string $id): RedirectResponse
    {
        try {
            $ticket = Ticket::with('usuarioAsignado')->findOrFail($id);
            $data   = $request->validated();

            // ── Detectar cambio de usuario asignado ──────────────────
            $usuarioAnteriorId = $ticket->usuario_asignado_id;
            $usuarioNuevoId    = $data['usuario_asignado_id'] ?? null;

            $cambioDeUsuario = $usuarioNuevoId
                && (int) $usuarioAnteriorId !== (int) $usuarioNuevoId;

            // ── Manejo de imagen ─────────────────────────────────────
            if ($request->input('eliminar_imagen') == '1' && $ticket->imagen) {
                Storage::disk('public')->delete('uploads/tickets/' . $ticket->imagen);
                $data['imagen'] = null;
            }

            if ($request->hasFile('imagen')) {
                if ($ticket->imagen) {
                    Storage::disk('public')->delete('uploads/tickets/' . $ticket->imagen);
                }
                $data['imagen'] = basename(
                    $request->file('imagen')->store('uploads/tickets', 'public')
                );
            } else {
                unset($data['imagen']);
            }

            // ── Guardar cambios del ticket ───────────────────────────
            $ticket->update($data);

            // ── Registrar traslado en comentarios ────────────────────
            if ($cambioDeUsuario) {
                $usuarioAnterior = $usuarioAnteriorId
                    ? User::with('tipoUsuario')->find($usuarioAnteriorId)
                    : null;
                $usuarioNuevo = User::with('tipoUsuario')->find($usuarioNuevoId);

                $nombreAnterior = $usuarioAnterior
                    ? $usuarioAnterior->name . ($usuarioAnterior->tipoUsuario ? ' "' . $usuarioAnterior->tipoUsuario->nombre_tipo . '"' : '')
                    : 'Sin asignar';

                $nombreNuevo = $usuarioNuevo->name
                    . ($usuarioNuevo->tipoUsuario ? ' "' . $usuarioNuevo->tipoUsuario->nombre_tipo . '"' : '');

                $quienReasigna = auth()->user();
                $quienNombre   = $quienReasigna->name
                    . ($quienReasigna->tipoUsuario ? ' "' . $quienReasigna->tipoUsuario->nombre_tipo . '"' : '');

                Comentario::create([
                    'ticket_id'      => $ticket->id,
                    'usuario_id'     => $usuarioNuevoId,
                    'mensaje'        => "🔄 Ticket reasignado por {$quienNombre}. "
                                      . "Usuario anterior: {$nombreAnterior}. "
                                      . "Nuevo responsable: {$nombreNuevo}.",
                    'fecha'          => now(),
                    'registrado_por' => $quienReasigna->name,
                    'estado'         => 1,
                ]);
            }

            return redirect()
                ->route('tickets.index')
                ->with('successMsg', 'El ticket se actualizó exitosamente'
                    . ($cambioDeUsuario ? ' y se registró el traslado.' : ''));

        } catch (QueryException $e) {
            Log::error('Error al actualizar ticket: '.$e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No se pudo actualizar el ticket. Verifique los datos e intente de nuevo.']);
        }
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        try {
            // Borrar imagen asociada si existe
            if ($ticket->imagen) {
                Storage::disk('public')->delete('uploads/tickets/' . $ticket->imagen);
            }

            $ticket->delete();

            return redirect()
                ->route('tickets.index')
                ->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar ticket: '.$e->getMessage());

            return redirect()
                ->route('tickets.index')
                ->withErrors('El registro tiene información relacionada.');
        } catch (Exception $e) {
            Log::error('Error inesperado: '.$e->getMessage());

            return redirect()
                ->route('tickets.index')
                ->withErrors('Ocurrió un error inesperado.');
        }
    }

    public function cambioestadoticket(Request $request): JsonResponse
    {
        $ticket = Ticket::find($request->id);

        if (! $ticket) {
            return response()->json(['mensaje' => 'Ticket no encontrado'], 404);
        }

        $ticket->estado = $request->estado;
        $ticket->save();

        return response()->json(['mensaje' => 'Estado actualizado correctamente']);
    }

    public function selectTicketPdf(): View
    {
        $tickets = Ticket::with(['cliente', 'usuarioAsignado'])->paginate(10);
        return view('tickets.select-pdf', compact('tickets'));
    }
// se descarga el ticket
    public function exportPdf(string $id)
    {
        if ($id === 'all') {
            $tickets = Ticket::with(['cliente', 'usuarioAsignado', 'comentarios.usuario'])->get();
            $pdf = Pdf::loadView('tickets.pdf-todos', compact('tickets'));
            return $pdf->download('tickets_historial_completo.pdf');
        }

        // Si es un cliente_id, generamos el historial de reparación
        if (is_numeric($id)) {
            // Intentar como ticket específico primero
            $ticket = Ticket::with(['cliente', 'usuarioAsignado', 'comentarios.usuario'])->findOrFail($id);
            $historial = $this->generarHistorialFicticio($ticket);
            $pdf = Pdf::loadView('tickets.pdf-historial', compact('ticket', 'historial'));
            return $pdf->download("ticket_{$id}_historial.pdf");
        }

        $ticket = Ticket::with(['cliente', 'usuarioAsignado', 'comentarios.usuario'])->findOrFail($id);
        $historial = $this->generarHistorialFicticio($ticket);
        $pdf = Pdf::loadView('tickets.pdf-historial', compact('ticket', 'historial'));
        return $pdf->download("ticket_{$id}_historial.pdf");
    }
//se abre el pdf en el navegador 
    public function viewPdf(string $id)
    {
        $ticket = Ticket::with(['cliente', 'usuarioAsignado', 'comentarios.usuario'])->findOrFail($id);
        $historial = $this->generarHistorialFicticio($ticket);
        $pdf = Pdf::loadView('tickets.pdf-historial', compact('ticket', 'historial'));
        return $pdf->stream("ticket_{$id}_historial.pdf");
    }
//se genera el excel 
    public function exportExcel(string $id)
    {
        if ($id === 'all') {
            $tickets  = Ticket::with(['cliente', 'usuarioAsignado'])->get();
            $filename = 'tickets_listado_completo.xlsx';
        } else {
            $ticket   = Ticket::with(['cliente', 'usuarioAsignado'])->findOrFail($id);
            $tickets  = collect([$ticket]);
            $filename = "ticket_{$id}.xlsx";
        }

        // Limpiar output buffer para evitar contaminación del binario XLSX
        while (ob_get_level()) {
            ob_end_clean();
        }

        return Excel::download(new TicketsExport($tickets), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

}
