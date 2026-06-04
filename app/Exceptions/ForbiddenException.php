<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    public function report() {
        // Puedes registrar la excepción en el registro de errores
    }

    public function render($request)
    {
        return response()->view('errors.403', [], 403);
    }
}
