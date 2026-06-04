<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\TipoUsuariosController;
use App\Http\Controllers\UsuariosController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});

Route::get('/about', function () {
    return 'acerca de nosotros';
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Rutas específicas ANTES de resource
    Route::get('tickets/select-pdf', [TicketsController::class, 'selectTicketPdf'])->name('tickets.selectPdf');
    Route::get('tickets/{id}/export-pdf', [TicketsController::class, 'exportPdf'])->name('tickets.exportPdf');
    Route::get('tickets/{id}/export-excel', [TicketsController::class, 'exportExcel'])->name('tickets.exportExcel');
    Route::get('tickets/{id}/view-pdf', [TicketsController::class, 'viewPdf'])->name('tickets.viewPdf');
    Route::get('clientes/select-pdf', [ClientesController::class, 'selectClientePdf'])->name('clientes.selectPdf');
    Route::get('clientes/{id}/export-pdf', [ClientesController::class, 'exportPdf'])->name('clientes.exportPdf');
    Route::get('clientes/{id}/export-excel', [ClientesController::class, 'exportExcel'])->name('clientes.exportExcel');
    Route::get('clientes/{id}/view-pdf', [ClientesController::class, 'viewPdf'])->name('clientes.viewPdf');
    Route::get('comentarios/select-pdf', [ComentariosController::class, 'selectComentarioPdf'])->name('comentarios.selectPdf');
    Route::get('comentarios/{id}/export-pdf', [ComentariosController::class, 'exportPdf'])->name('comentarios.exportPdf');
    Route::get('comentarios/{id}/export-excel', [ComentariosController::class, 'exportExcel'])->name('comentarios.exportExcel');
    Route::get('comentarios/{id}/view-pdf', [ComentariosController::class, 'viewPdf'])->name('comentarios.viewPdf');
    
    // Resources
    Route::resource('clientes', ClientesController::class);
    Route::resource('tickets', TicketsController::class);
    Route::resource('comentarios', ComentariosController::class);
    Route::resource('tipousuarios', TipoUsuariosController::class);
    Route::resource('usuarios', UsuariosController::class);
    
    // Cambios de estado
    Route::get('cambioestadoticket', [TicketsController::class, 'cambioestadoticket'])->name('cambioestadoticket');
    Route::get('cambioestadocliente', [ClientesController::class, 'cambioestadocliente'])->name('cambioestadocliente');
    Route::get('cambioestadotipousuarios', [TipoUsuariosController::class, 'cambioestadotipousuarios'])->name('cambioestadotipousuarios');
    Route::get('cambioestadousuario', [UsuariosController::class, 'cambioestadousuario'])->name('cambioestadousuario');
    Route::get('cambioestadocomentario', [ComentariosController::class, 'cambioestadocomentario'])->name('cambioestadocomentario');
});

Auth::routes();

// Rutas para visualizar páginas de error (solo para desarrollo)
Route::get('/errors/403', function() {
    return view('errors.403');
})->name('error.403');

Route::get('/errors/404', function() {
    return view('errors.404');
})->name('error.404');

Route::get('/errors/500', function() {
    return view('errors.500');
})->name('error.500');

Route::get('/errors/419', function() {
    return view('errors.419');
})->name('error.419');

Route::get('/errors/503', function() {
    return view('errors.503');
})->name('error.503');
