<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        'current_password',
        'password',
        'password_confirmation',
    ];
    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if (!$request->ajax() && $request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                $errors = $exception->validator->errors();
                $error = $errors->all();

                return response()->json([
                    'status' => false,
                    'message' => $error[0],
                    'data' => [],
                    // 'errors' => [
                    //     $exception->validator->errors()
                    // ]
                ], 500);
            }

            return response()->json(['status' => false, 'message' => $exception->getMessage(), 'data' => []], 500);
        }
        return parent::render($request, $exception);

        // return $request->expectsJson()
        //     ? $this->prepareJsonResponse($request, $exception)
        //     : $this->prepareResponse($request, $exception);
    }
}
