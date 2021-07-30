<?php declare(strict_types = 1);

namespace App\Http\Services\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiResponseService implements IApiResponseService
{
    private const STATUS_FIELD = 'success';
    private const DATA_FIELD = 'data';
    private const MESSAGE_FIELD = 'message';
    private const TIMESTAMP_FIELD = 'timestamp';

    private const SUCCESS_VALUE = true;
    private const FAILED_VALUE = false;

    private ResponseFactory $responseFactory;

    private Response $responseCodes;

    /**
     * ApiResponseService constructor.
     *
     * @param ResponseFactory $responseFactory
     * @param Response $responseCodes
     */
    public function __construct(ResponseFactory $responseFactory, Response $responseCodes)
    {
        $this->responseFactory = $responseFactory;
        $this->responseCodes = $responseCodes;
    }

    /**
     * Successful response.
     *
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function responseSuccess(mixed $data): JsonResponse
    {
        $responseBody = [
            self::STATUS_FIELD => self::SUCCESS_VALUE,
            self::TIMESTAMP_FIELD => time(),
        ];

        if ($data) {
            $responseBody = array_merge($responseBody, [self::DATA_FIELD => $data]);
        }

        return $this->responseFactory->json($responseBody, $this->responseCodes::HTTP_OK);
    }

    /**
     * Failed response.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseFailed(string $message = 'Unexpected error', mixed $data = null): JsonResponse
    {
        $responseBody = [
            self::STATUS_FIELD => false,
            self::TIMESTAMP_FIELD => time(),
        ];

        if ($message) {
            $responseBody = array_merge($responseBody, [self::MESSAGE_FIELD => $message]);
        }

        if ($data) {
            $responseBody = array_merge($responseBody, [self::DATA_FIELD => $data]);
        }

        return $this->responseFactory->json($responseBody, $this->responseCodes::HTTP_OK);
    }
}
