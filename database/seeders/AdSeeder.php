<?php

namespace Database\Seeders;

use App\Http\Services\Ad\AdService;
use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdSeeder extends Seeder
{
    private const RECORDS_COUNT = 30;

    private AdService $adService;

    /**
     * AdSeeder constructor.
     *
     * @param AdService $adService
     */
    public function __construct(AdService $adService)
    {
        $this->adService = $adService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [];

        for ( $i = 0; self::RECORDS_COUNT > $i; $i++) {

            $usdTotal = bcdiv( (string) rand(300, 30000), 1);
            $start = Carbon::now();
            $end = Carbon::now()->addDays(rand(0, 30));

            $record = new Ad();
            $record->title = Str::random(20);
            $record->dateStart = $start->toDateTimeString();
            $record->dateEnd = $end->toDateTimeString();
            $record->usdDaily = $this->adService->calculateDailyUsd($usdTotal, $start, $end);
            $record->usdTotal = $usdTotal;
            $record->save();
        }

    }
}
