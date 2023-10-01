<?php

namespace App\Infrastructure\Traits\Jsons;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\BackedEnumCaseNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\View\ViewException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use TypeError;

trait JsonExceptionHandlerTrait
{
    /**
     * @param Throwable $handler
     * @return JsonResponse
     */
    protected function reportException(Throwable $handler): JsonResponse
    {
        if ($handler instanceof ValidationException) {
            return $this->_validationError($handler);
        }

        if ($handler instanceof TokenMismatchException) {
            return $this->_reportError($handler, trans('base::exception.token.mismatch.exception'), "HTTP_BAD_REQUEST", ResponseAlias::HTTP_BAD_REQUEST);
        }

        if ($handler instanceof QueryException) {
            return $this->_reportError($handler, trans('base::exception.query.exception'), "HTTP_BAD_REQUEST", ResponseAlias::HTTP_BAD_REQUEST);
        }

        if ($handler instanceof InternalErrorException || $handler instanceof FatalError) {
            return $this->_reportError($handler, trans('base::exception.internal.server.exception'));
        }

        if ($handler instanceof ModelNotFoundException) {
            return $this->_reportError($handler, trans('base::exception.model.not.found.exception'), "HTTP_NOT_FOUND", ResponseAlias::HTTP_NOT_FOUND);
        }


        if ($handler instanceof AuthorizationException) {
            return $this->_reportError($handler, trans('base::exception.authorization.exception'), "HTTP_FORBIDDEN", ResponseAlias::HTTP_FORBIDDEN);
        }

        if ($handler instanceof AuthenticationException) {
            return $this->_reportError($handler, trans('base::exception.authentication.exception'), "HTTP_UNAUTHORIZED", ResponseAlias::HTTP_UNAUTHORIZED);
        }

        if ($handler instanceof MethodNotAllowedHttpException) {
            return $this->_reportError($handler, trans('base::exception.method.not.allowed.http.exception'), "HTTP_METHOD_NOT_ALLOWED", ResponseAlias::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($handler instanceof NotFoundHttpException) {
            return $this->_reportError($handler, trans('base::exception.not.found.http.exception'), "HTTP_NOT_FOUND", ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($handler instanceof ViewException) {
            return $this->_reportError($handler, trans('base::exception.view.exception'), "HTTP_BAD_REQUEST", ResponseAlias::HTTP_BAD_REQUEST);
        }

        if ($handler instanceof TypeError) {
            return $this->_reportError($handler, trans('base::exception.type.error.exception'), "HTTP_UNPROCESSABLE_ENTITY", ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($handler instanceof ThrottleRequestsException) {
            return $this->_reportError($handler, trans('base::exception.throttle.request.exception'), "HTTP_UNPROCESSABLE_ENTITY", ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($handler instanceof BackedEnumCaseNotFoundException) {

            return $this->_reportError($handler, trans('base::exception.backed.enum_case.not_found.exception'), "HTTP_UNPROCESSABLE_ENTITY", ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->_reportError($handler, trans($handler->getMessage()), "HTTP_BAD_REQUEST", ResponseAlias::HTTP_BAD_REQUEST);

    }

    /**
     * @param Throwable $handler
     * @param string $message
     * @param string $statusAbb
     * @param int $statusCode
     * @return JsonResponse
     */
    private function _reportError(Throwable $handler, string $message = "There was an internal server error in your application", string $statusAbb = "HTTP_INTERNAL_SERVER_ERROR", int $statusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {

        if (config('base.settings.app_env') === 'local' && !empty($handler->getMessage())) {
            return $this->_jsonResponse($handler->getMessage(), $statusAbb, $statusCode);
        }

        return $this->_jsonResponse($message, $statusAbb, $statusCode);
    }

    /**
     * @param ValidationException $e
     * @param string $statusAbb
     * @param int $statusCode
     * @return JsonResponse
     */
    private function _validationError(ValidationException $e, string $statusAbb = "HTTP_UNPROCESSABLE_ENTITY", int $statusCode = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        $validationErrors = $e->validator->errors()->getMessages();

        if (is_array($validationErrors)) {
            $validationErrors = reset($validationErrors);
            return $this->_reportError($e, $validationErrors[0], $statusAbb, $statusCode);
        }

        $validationErrors = $e->getMessage();
        return $this->_reportError($e, $validationErrors, $statusAbb, $statusCode);
    }

    /**
     * @param string $message
     * @param string $statusAbb
     * @param int $statusCode
     * @return JsonResponse
     */
    private function _jsonResponse(string $message, string $statusAbb, int $statusCode): JsonResponse
    {
        $payload = ['error' => $message, 'code' => $statusAbb];
        return $this->apiException($payload, $statusCode);
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function isJsonApi(Request $request): bool
    {
        if (str_contains($request->getUri(), '/payment/redirect') || str_contains($request->getUri(), '/payment/verify')) {
            return false;
        }

        return str_contains($request->getUri(), '/oauth/token') || str_contains($request->getUri(), '/api/') ||
            $request->expectsJson() || $request->wantsJson() || ($request->ajax() && !$request->pjax() && $request->acceptsAnyContentType());
    }
}
