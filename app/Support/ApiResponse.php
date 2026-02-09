<?php

namespace App\Support;

use App\Enums\ResponseCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

class ApiResponse
{
    /**
     * Return a success response.
     */
    public static function success(mixed $data = null, string $message = 'Success', ResponseCode $code = ResponseCode::Success): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code->value);
    }

    /**
     * Return a created response.
     */
    public static function created(mixed $data = null): JsonResponse
    {
        return static::success(
            data: $data,
            message: trans('response.success.created'),
            code: ResponseCode::Created,
        );
    }

    /**
     * Return a updated response.
     */
    public static function updated(mixed $data = null): JsonResponse
    {
        return static::success(
            data: $data,
            message: trans('response.success.updated'),
        );
    }

    /**
     * Return a deleted response.
     */
    public static function deleted(mixed $data = null): JsonResponse
    {
        return static::success(
            data: $data,
            message: trans('response.success.deleted'),
        );
    }

    /**
     * Return an error response.
     */
    public static function error(string $message = 'Error', mixed $errors = null, ResponseCode $code = ResponseCode::ErrorBadRequest): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code->value);
    }

    /**
     * Return a validation error response.
     *
     * @param  ValidationException|MessageBag|mixed[]  $errors
     */
    public static function validationError(ValidationException|MessageBag|array $errors, string $message = 'Validation failed'): JsonResponse
    {
        $errorMessages = $errors instanceof ValidationException
            ? $errors->errors()
            : ($errors instanceof MessageBag ? $errors->toArray() : $errors);

        return static::error(
            message: $message,
            errors: $errorMessages,
            code: ResponseCode::ErrorValidation,
        );
    }

    /**
     * Return a not found response.
     */
    public static function notFound(string $message = 'Resource not found', mixed $errors = null): JsonResponse
    {
        return static::error(
            message: $message,
            errors: $errors,
            code: ResponseCode::ErrorNotFound,
        );
    }

    /**
     * Return an unauthorized response.
     */
    public static function unauthorized(string $message = 'Unauthorized', mixed $errors = null): JsonResponse
    {
        return static::error(
            message: $message,
            errors: $errors,
            code: ResponseCode::ErrorUnauthorized,
        );
    }

    /**
     * Return a forbidden response.
     */
    public static function forbidden(string $message = 'Forbidden', mixed $errors = null): JsonResponse
    {
        return static::error(
            message: $message,
            errors: $errors,
            code: ResponseCode::ErrorForbidden,
        );
    }

    /**
     * Return a failed update.
     */
    public static function failedUpdate(): JsonResponse
    {
        return static::error(trans('response.failed.update'));
    }

    /**
     * Return a failed delete.
     */
    public static function failedDelete(): JsonResponse
    {
        return static::error(trans('response.failed.delete'));
    }
}