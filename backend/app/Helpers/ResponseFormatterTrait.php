<?php declare(strict_types = 1);

namespace App\Helpers;
use Illuminate\Http\JsonResponse;

trait ResponseFormatterTrait {
  public function successResponse(array $data = [], int $code = 200): JsonResponse {
    return response()->json(['code' => $code, 'data' => $data], $code);
  }

  public function errorResponse(array|string $errorMessage = null, int $code = 400): JsonResponse {
    if (is_null($errorMessage) || empty($errorMessage)) {
      $errorMessage = is_array($errorMessage) ? [] : '';
    }

    return response()->json([
      'code'   => $code,
      'errors' => [
        'message' => $errorMessage
      ]
    ], $code);
  }
}
