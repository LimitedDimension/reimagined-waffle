<?php declare(strict_types = 1);

namespace App\Http\Services\Ad;

use App\Exceptions\InvalidDatesRangeException;
use App\Exceptions\InvalidTotalCurrencyValue;
use App\Http\Repositories\Ad\AdRepository;
use App\Http\Services\AdImage\AdImageService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdService implements IAdService
{
    private Carbon $carbon;

    private AdRepository $adRepository;

    private AdImageService $adImageService;

    /**
     * AdService constructor.
     *
     * @param Carbon $carbon
     * @param AdRepository $adRepository
     * @param AdImageService $adImageService
     */
    public function __construct(Carbon $carbon, AdRepository $adRepository, AdImageService $adImageService)
    {
        $this->carbon = $carbon;
        $this->adRepository = $adRepository;
        $this->adImageService = $adImageService;
    }

    /**
     * Create an Ad.
     *
     * @param string $title
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $usdTotal
     * @param array|null $images
     *
     * @return Model
     *
     * @throws InvalidTotalCurrencyValue|InvalidDatesRangeException
     */
    public function createAd(
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdTotal,
        ?array $images = null
    ): Model {
        $start = $this->parseDate($dateStart);
        $end = $this->parseDate($dateEnd);

        $record = $this->adRepository->createAd(
            $title,
            $dateStart,
            $dateEnd,
            $this->calculateDailyUsd($usdTotal, $start, $end),
            $usdTotal
        );

        $record->save();

        if ($images) {
            $storedImages = $this->adImageService->storeImages($images);
            $record->images()->saveMany($storedImages);
        }

        return $record;
    }

    public function updateAd(
        int $id,
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdTotal,
        ?array $newImages = null,
        ?array $deletedImages = null
    ): Model {
        $start = $this->parseDate($dateStart);
        $end = $this->parseDate($dateEnd);

        $record = $this->adRepository->updateAd(
            $id,
            $title,
            $start->toDateTimeString(),
            $end->toDateTimeString(),
            $this->calculateDailyUsd( $usdTotal, $start, $end),
            $usdTotal
        );

        if ($newImages) {
            $storedImages = $this->adImageService->storeImages($newImages);
            $record->images()->saveMany($storedImages);
        }

        if ($deletedImages) {
           $this->adImageService->deleteImagesByIds($deletedImages);
        }

        $record->save();

        return $record;
    }

    /**
     *  Calculate daily usd expenses based on days
     *
     * @param string $total
     * @param Carbon $dateStart
     * @param Carbon $dateEnd
     *
     * @return string
     *
     * @throws InvalidDatesRangeException
     * @throws InvalidTotalCurrencyValue
     */
    public function calculateDailyUsd(string $total, Carbon $dateStart, Carbon $dateEnd): string
    {
        if (!$dateStart || !$dateEnd || $dateStart > $dateEnd) {
            throw new InvalidDatesRangeException();
        }

        if ($total < 0) {
            throw new InvalidTotalCurrencyValue();
        }

        $daysDifference = $dateStart->diffInDays($dateEnd);

        if ($daysDifference <= 0) {
            $daysDifference = 1;
        }

        $totalFormatted = str_replace(',', '', $total);

        return bcdiv($totalFormatted, (string) $daysDifference, 2);
    }

    /**
     * @param string $date
     *
     * @return Carbon
     */
    private function parseDate(string $date): Carbon
    {
        return $this->carbon->parse($date);
    }

}
