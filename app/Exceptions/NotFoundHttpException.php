<?php

namespace App\Exceptions;

use Exception;

class NotFoundHttpException extends Exception
{
    public function report()
    {
        //
    }

    public function render($request)
    {
        return response()->view('errors.404', [], 404);
    }
}
