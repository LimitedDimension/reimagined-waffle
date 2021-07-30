<?php

namespace Tests\Unit;

use App\Exceptions\InvalidDatesRangeException;
use App\Exceptions\InvalidTotalCurrencyValue;
use App\Http\Services\Ad\AdService;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class AdServiceTest extends TestCase
{
    private AdService $adService;

    public function setUp(): void
    {
        $this->adService = app()->make(AdService::class);
    }

    /**
     * @large
     */
    public function testCalculateDailyUsd()
    {
        $daysDifference = 2;
        $usdTotal = 500;
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays($daysDifference);

        $this->assertEquals($usdTotal / 2, $this->adService->calculateDailyUsd($usdTotal, $startDate, $endDate));
    }

    /**
     * @large
     */
    public function testCalculateDailyUsdZeroDaysDifference()
    {
        $usdTotal = 500;
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        $this->expectNotToPerformAssertions();
        $this->adService->calculateDailyUsd($usdTotal, $startDate, $endDate);
    }

    /**
     * @large
     */
    public function testWrongNegativeUsdValue()
    {
        $usdTotal = -500;
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDay();

        $this->expectException(InvalidTotalCurrencyValue::class);
        $this->adService->calculateDailyUsd($usdTotal, $startDate, $endDate);
    }

    /**
     * @large
     */
    public function testWrongDatesRange()
    {
        $usdTotal = 500;
        $startDate = Carbon::now();
        $endDate = Carbon::now()->subDay();

        $this->expectException(InvalidDatesRangeException::class);
        $this->adService->calculateDailyUsd($usdTotal, $startDate, $endDate);
    }
}
