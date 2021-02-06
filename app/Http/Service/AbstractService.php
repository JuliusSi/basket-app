<?php

declare(strict_types=1);

namespace App\Http\Service;

use Core\Helpers\Traits\SerializationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseBuilder;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * Class AbstractService
 * @package App\Http\Service
 */
abstract class AbstractService
{
    use SerializationTrait;

    /**
     * @param  array|string  $data
     * @param  int  $status
     * @return JsonResponse
     */
    protected function createJsonResponse(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return ResponseBuilder::json($data, $status)->header('Content-Type', 'application/json');
    }

    /**
     * @param  string  $data
     * @param  int  $status
     * @return Response
     */
    protected function createResponse(string $data, int $status = BaseResponse::HTTP_OK): Response
    {
        return ResponseBuilder::make($data, $status);
    }
}
