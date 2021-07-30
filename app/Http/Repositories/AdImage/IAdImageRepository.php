<?php declare(strict_types=1);

namespace App\Http\Repositories\AdImage;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IAdImageRepository
{
    public function createAdImage(string $src): Builder|Model;

    public function appendToAd(Ad $ad): void;

    public function getByIds(array $ids): Collection;
}
