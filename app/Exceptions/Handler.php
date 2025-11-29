<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);

        try {
            // Send error details to admin email
            Mail::raw(
                "Erreur détectée :\n" . $exception->getMessage() . "\n" . $exception->getTraceAsString(),
                function ($message) {
                    $message->to('lalyaisidore@gmail.com')
                            ->subject('Erreur sur CompteEurope');
                }
            );
        } catch (Throwable $mailException) {
            // Ignore mail errors to avoid infinite loop
        }
    }
}
