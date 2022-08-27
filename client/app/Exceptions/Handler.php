<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    protected $exceptionMap = [
        ModelNotFoundException::class => [
            'code' => 404,
            'message' => 'Could not find what you were looking for.',
            'adaptMessage' => false,
        ],

        NotFoundHttpException::class => [
            'code' => 404,
            'message' => 'Could not find what you were looking for.',
            'adaptMessage' => false,
        ],

        MethodNotAllowedHttpException::class => [
            'code' => 405,
            'message' => 'This method is not allowed for this endpoint.',
            'adaptMessage' => false,
        ],

        ValidationException::class => [
            'code' => 422,
            'message' => 'Some data failed validation in the request',
            'adaptMessage' => false,
        ],

        \InvalidArgumentException::class => [
            'code' => 400,
            'message' => 'You provided some invalid input value',
            'adaptMessage' => true,
        ],

        JWTException::class => [
            'code' => 401,
            'message' => 'Invalid authentication action',
            'adaptMessage' => true,
        ],
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Throwable $exception
     * @return JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $response = $this->formatException($exception);

        return response()->json(['error' => $response], $response['status'] ?? 500);
    }

    /*HELPER*/
    /**
     * @param Throwable $exception
     * @return array
     */
    protected function formatException(\Throwable $exception): array
    {
        $exceptionClass = get_class($exception);

        $definition = $this->exceptionMap[$exceptionClass] ?? [
                'code' => 500,
                'message' => $exception->getMessage() ?? 'Something went wrong while processing your request',
                'adaptMessage' => false,
            ];

        if (!empty($definition['adaptMessage'])) {
            $definition['message'] = $exception->getMessage() ?? $definition['message'];
        }

        $validation = isset($exception->response)
            ? json_decode($exception->response->getContent(), true)['errors']
            : '';

        return [
            'status' => $definition['code'] ?? 500,
            //'title' => $definition['title'] ?? 'Error',
            'message' => $definition['message'],
            'description' => $validation,
        ];
    }
}
