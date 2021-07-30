<?php declare(strict_types = 1);

namespace App\Http\Repositories\AdImage;

use App\Models\Ad;
use App\Models\AdImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AdImageRepository implements IAdImageRepository
{
    private AdImage $model;

    /**
     * AdImageRepository constructor.
     *
     * @param AdImage $model
     */
    public function __construct(AdImage $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $src
     *
     * @return Builder|Model
     */
    public function createAdImage(string $src): Builder|Model
    {
        $record = $this->model->newQuery()->make();
        $record->src = $src;

        return $record;
    }

    /**
     * @param Ad $ad
     */
    public function appendToAd(Ad $ad): void
    {
        $this->model->ad()->associate($ad);
    }

    /**
     * @param array $ids
     *
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        return $this->model->newQuery()->whereIn('id', $ids)->get();
    }
}
