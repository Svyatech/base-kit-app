<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $mediable_type
 * @property int $mediable_id
 * @property string $disk
 * @property string $path
 * @property string|null $alt
 * @property string|null $caption
 * @property int $sort_order
 * @property-read Model $mediable
 */
class Media extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'disk',
        'path',
        'alt',
        'caption',
        'sort_order',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
