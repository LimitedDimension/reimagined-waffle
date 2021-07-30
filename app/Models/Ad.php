<?php declare(strict_types = 1);

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Ad
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property DateTime $dateStart
 * @property DateTime $dateEnd
 * @property float $usdDaily
 * @property float $usdTotal
 */
class Ad extends Model
{
    use HasFactory;

    public function images(): HasMany
    {
        return $this->hasMany(AdImage::class);
    }
}
