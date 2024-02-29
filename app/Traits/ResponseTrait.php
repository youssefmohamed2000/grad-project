<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function sendResponse(
        mixed $result = [],
        string $message = '',
        array $paginationData = [],
        int $code = 200
    ): JsonResponse {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $result,
            'pagination' => $paginationData
        ];

        return response()->json(array_filter($response), $code);
    }

    public function sendError(
        string $error = '',
        array $errorMessages = [],
        int $code = 404
    ): JsonResponse {
        $response = [
            'status' => 'failed',
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
