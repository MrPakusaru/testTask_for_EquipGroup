<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

abstract class Controller
{
    /**
     * Метод, упаковывающий ответ в формат JSON
     * @param $data
     * @param null $additional
     * @return JsonResponse
     */
    public static function prepareResponse($data, $additional = null): JsonResponse
    {
        return Response::json([
            'data' => $data,
            'additional' => $additional
        ]);
    }
}
