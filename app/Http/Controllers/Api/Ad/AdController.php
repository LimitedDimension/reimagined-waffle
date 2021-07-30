<?php declare(strict_types = 1);

namespace App\Http\Controllers\Api\Ad;

use App\Exceptions\InvalidDatesRangeException;
use App\Exceptions\InvalidTotalCurrencyValue;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Ad\AdRepository;
use App\Http\Requests\AdCreateRequest;
use App\Http\Requests\AdUpdateRequest;
use App\Http\Resources\AdListResource;
use App\Http\Services\Ad\AdService;
use App\Http\Services\Api\ApiResponseService;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\Factory as ViewFactory;
use Psr\SimpleCache\InvalidArgumentException;

class AdController extends Controller
{
    private const CACHE_TIMEOUT = 60;

    private const LIST_CACHE_KEY = self::class . '_ad-list';

    private ApiResponseService $apiResponseService;

    private AdService $adService;

    private AdRepository $adRepository;

    private CacheRepository $cache;

    /**
     * AdController constructor.
     * d
     * @param ViewFactory $view
     * @param ApiResponseService $apiResponseService
     * @param AdService $adService
     * @param AdRepository $adRepository
     * @param CacheRepository $cache
     */
    public function __construct(
        ViewFactory $view,
        ApiResponseService $apiResponseService,
        AdService $adService,
        AdRepository $adRepository,
        CacheRepository $cache
    ) {
        parent::__construct($view);

        $this->apiResponseService = $apiResponseService;
        $this->adService = $adService;
        $this->adRepository = $adRepository;
        $this->cache = $cache;
    }

    /**
     * @param AdCreateRequest $request
     *
     * @return JsonResponse
     *
     * @throws InvalidDatesRangeException|InvalidTotalCurrencyValue|InvalidArgumentException
     */
    public function createAd(AdCreateRequest $request): JsonResponse
    {
        $record = $this->adService->createAd(...$request->all());

        // Clear the cached list data since we know there was changes
        // so we can show actual data right away
        $this->cache->delete(self::LIST_CACHE_KEY);

        return $this->apiResponseService->responseSuccess(new AdListResource($record->refresh()));
    }

    /**
     * @param AdUpdateRequest $request
     *
     * @return JsonResponse
     *
     * @throws InvalidArgumentException
     */
    public function updateAd(AdUpdateRequest $request): JsonResponse
    {
        $record = $this->adService->updateAd((int) $request->input('id'), ...$request->except(['id']));

        // Clear the cached list data since we know there was changes
        // so we can show actual data right away
        $this->cache->delete(self::LIST_CACHE_KEY);

        return $this->apiResponseService->responseSuccess(new AdListResource($record->refresh()));
    }

    /**
     * @return JsonResponse
     *
     * @throws InvalidArgumentException
     */
    public function list(): JsonResponse
    {
        $resultData = $this->cache->get(self::LIST_CACHE_KEY);

        if (!$resultData) {
            $resultData = $this->adRepository->getAllWithImages();
            $this->cache->put(self::LIST_CACHE_KEY, $resultData, self::CACHE_TIMEOUT);
        }

        return $this->apiResponseService->responseSuccess(
            adListResource::collection($resultData)
        );
    }
}
