<?php

namespace App\Helpers;

use App\Helpers\Constants\ResponseConstants;

class ApiResponse
{
    public static function makeResponse($message, $status, $payload = null)
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'payload' => $payload
        ]);
    }

    public static function success($message, $payload  = null)
    {
        return self::makeResponse($message, ResponseConstants::RESPONSE_SUCCESS, $payload );
    }

    public static function error($message, $payload = null)
    {
        return self::makeResponse($message, ResponseConstants::RESPONSE_ERROR, $payload);
    }

    public static function noauth($message, $payload = null)
    {
        return self::makeResponse($message, ResponseConstants::RESPONSE_UNAUTHENTICATED, $payload);
    }
}