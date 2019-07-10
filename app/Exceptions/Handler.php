<?php

namespace App\Exceptions;

use App\Modules\Auditlog\Models\Auditlog;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Unathorized access (Roles)
        if ($exception instanceof UnauthorizedException) {
            Auditlog::critical('Auth', $exception->getMessage(), null, json_encode([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'headers' => (array) $request->headers,
                'data' => $request->all(),
            ]));

            // not api call, redirect to login
            if (!$request->ajax() && !$request->wantsJson()) {
                Auth::guard()->logout();
                return redirect()->guest(route('login'));
            }
        }

        return parent::render($request, $exception);
    }
}
