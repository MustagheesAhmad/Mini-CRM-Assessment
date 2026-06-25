<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(mixed $data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        $payload = [
            'success' => true,
            'message' => $message,
        ];

        if (! is_null($data)) {
            $payload['data'] = $data;
        }

        return response()->json($payload, $status);
    }

    protected function created(mixed $data = null, string $message = 'Created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    protected function noContent(string $message = 'Deleted successfully'): JsonResponse
    {
        return response()->json(['success' => true, 'message' => $message], 200);
    }

    protected function error(string $message, int $status = 400, mixed $errors = null): JsonResponse
    {
        $payload = [
            'success' => false,
            'message' => $message,
        ];

        if (! is_null($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $status);
    }

    protected function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->error($message, 401);
    }

    protected function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->error($message, 403);
    }

    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->error($message, 404);
    }
}
