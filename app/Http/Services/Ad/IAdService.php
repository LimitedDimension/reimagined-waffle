<?php declare(strict_types = 1);

namespace App\Http\Services\Ad;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

interface IAdService
{
    public function createAd(
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdTotal,
        ?array $images
    ): Model;

    public function updateAd(
        int $id,
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdTotal,
        ?array $newImages = null,
        ?array $deletedImages = null
    ): Model;

    public function calculateDailyUsd(string $total, Carbon $dateStart, Carbon $dateEnd): string;
}
