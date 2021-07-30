<?php declare(strict_types = 1);

namespace App\Http\Services\Api;

use Illuminate\Http\JsonResponse;

interface IApiResponseService
{
    public function responseSuccess(mixed $data): JsonResponse;

    public function responseFailed(string $message, mixed $data): JsonResponse;
}
