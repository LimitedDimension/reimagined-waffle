<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AdImage
 * @package App\Models
 *
 * @property int $id
 * @property int $ad_id
 * @property int $src
 */
class AdImage extends Model
{
    use HasFactory;

    protected $table = 'ads_images';

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
