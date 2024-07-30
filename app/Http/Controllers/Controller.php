<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Constants\Response as ResponseConstant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Controller
{
    /**
     *
     * @param JsonResource $result
     * @param int $code
     *
     * @return JsonResponse
     */
    public function sendResponse(JsonResource $result, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            ResponseConstant::SUCCESS => true,
            ResponseConstant::DATA => $result,
        ], $code);
    }

    /**
     *
     * @param string $error
     * @param int $code
     *
     * @return JsonResponse
     */
    public function sendError(string $error, int $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return response()->json([
            ResponseConstant::SUCCESS => false,
            ResponseConstant::MESSAGE => $error,
        ], $code);
    }
}
