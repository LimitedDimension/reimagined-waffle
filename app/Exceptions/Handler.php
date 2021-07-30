<?php declare(strict_types = 1);

namespace App\Exceptions;

use App\Http\Services\Api\ApiResponseService;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    private const CANNOT_CREATE_AD_MSG = 'Cannot create ad';

    private const INVALID_DATES_RANGE_MSG = 'Invalid dates range or one of the dates is earlier than the other';

    private const INVALID_TOTAL_CURRENCY_MSG = 'Invalid total currency value';

    private const NOT_FOUND_MSG = 'Not found';

    private const NOT_ALLOWED_MSG = 'Not allowed';

    private const VALIDATION_ERROR_MSG = 'Validation error';

    private ApiResponseService $apiResponseService;

    public function __construct(Container $container, ApiResponseService $apiResponseService)
    {
        parent::__construct($container);

        $this->apiResponseService = $apiResponseService;
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e) {
            if ($e instanceof CannotCreateAdRecordException) {
                return $this->apiResponseService->responseFailed(self::CANNOT_CREATE_AD_MSG);
            }

            if ($e instanceof InvalidDatesRangeException) {
                return $this->apiResponseService->responseFailed(self::INVALID_DATES_RANGE_MSG);
            }

            if ($e instanceof InvalidTotalCurrencyValue) {
                return $this->apiResponseService->responseFailed(self::INVALID_TOTAL_CURRENCY_MSG);
            }

            if ($e instanceof NotFoundHttpException) {
                return $this->apiResponseService->responseFailed(self::NOT_FOUND_MSG);
            }

            if ($e instanceof MethodNotAllowedException) {
                return $this->apiResponseService->responseFailed(self::NOT_ALLOWED_MSG);
            }

            if ($e instanceof CustomValidationException) {
                return $this->apiResponseService->responseFailed(self::VALIDATION_ERROR_MSG);
            }

            return $this->apiResponseService->responseFailed($e->getMessage());
        });
    }
}
