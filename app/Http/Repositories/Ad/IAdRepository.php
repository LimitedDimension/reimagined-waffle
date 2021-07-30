<?php declare(strict_types = 1);

namespace App\Http\Repositories\Ad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IAdRepository
{
    public function updateAd(
        int $id,
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdDaily,
        string $usdTotal
    ): Model;

    public function getWithImagesById(int $id): null|Model;

    public function addAdImages(int $id, array $images): void;

    public function getAllWithImages(): Collection;
}
