<?php declare(strict_types = 1);

namespace App\Http\Repositories\Ad;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdRepository implements IAdRepository
{
    private Ad $model;

    /**
     * AdRepository constructor.
     *
     * @param Ad $model
     */
    public function __construct(Ad $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $title
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $usdDaily
     * @param string $usdTotal
     *
     * @return Model
     */
    public function createAd(
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdDaily,
        string $usdTotal
    ): Model {
        $record = $this->model->newQuery()->make();

        $record->title = $title;
        $record->dateStart = $dateStart;
        $record->dateEnd = $dateEnd;
        $record->usdDaily = $usdDaily;
        $record->usdTotal = $usdTotal;

        return $record;
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $dateStart
     * @param string $dateEnd
     * @param string $usdDaily
     * @param string $usdTotal
     *
     * @return Model
     *
     * @throws NotFoundHttpException
     */
    public function updateAd(
        int $id,
        string $title,
        string $dateStart,
        string $dateEnd,
        string $usdDaily,
        string $usdTotal
    ): Model {
        $record = $this->model->newQuery()->with('images')->where('id', $id)->first();

        if (!$record) {
            throw new NotFoundHttpException();
        }

        $record->title = $title;
        $record->dateStart = $dateStart;
        $record->dateEnd = $dateEnd;
        $record->usdDaily = $usdDaily;
        $record->usdTotal = $usdTotal;

        return $record;
    }

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function getWithImagesById(int $id): null|Model
    {
        return $this->model->newQuery()->where('id', $id)->with('images')->first();
    }

    /**
     * @param int $id
     *
     * @param array $images
     */
    public function addAdImages(int $id, array $images): void
    {
        /**
         * @var Ad
         */
        $record = $this->model->newQuery()->where('id', $id)->get()->first();

        if (!$record) {
            throw new ModelNotFoundException();
        }

        $record->images->add($images);
    }

    /**
     * @return Collection
     */
    public function getAllWithImages(): Collection
    {
        return $this->model->newQuery()->with('images')->get();
    }
}
