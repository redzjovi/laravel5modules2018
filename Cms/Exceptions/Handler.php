<?php

namespace Modules\Cms\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
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
        /*
         * We add a custom exception renderer here since this will be an api only backend.
         * So we need to convert every exception to a json response.
         */
        if ($request->ajax() || $request->wantsJson()) {
            return $this->getJsonResponse($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Get the json response for the exception.
     *
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponse($request, Exception $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json(['message' => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json(['message' => trans('cms::cms.data_not_found')], Response::HTTP_NOT_FOUND);
        } else {
            return parent::render($request, $exception);
        }
    }
}
