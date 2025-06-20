<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(string $message = null, $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function error(string $message, $errors = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'data' => [],
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
