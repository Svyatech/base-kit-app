<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property int $city_id
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $address
 * @property string|null $google_maps_url
 * @property string|null $price_note
 * @property string|null $working_hours
 * @property \Illuminate\Support\Carbon|null $fact_checked_at
 * @property-read City $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $media
 */
class Place extends Model
{
    protected $fillable = [
        'city_id',
        'type',
        'name',
        'slug',
        'description',
        'address',
        'google_maps_url',
        'price_note',
        'working_hours',
        'fact_checked_at',
    ];

    protected function casts(): array
    {
        return [
            'fact_checked_at' => 'date',
        ];
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsToMany<Article, $this>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)->withPivot('sort_order');
    }

    /**
     * @return MorphMany<Media, $this>
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('sort_order');
    }
}
