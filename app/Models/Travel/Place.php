<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property int $city_id
 * @property int|null $parent_id
 * @property string $type
 * @property array $name
 * @property array $slug
 * @property array|null $description
 * @property string|null $address
 * @property string|null $google_maps_url
 * @property float|null $lat
 * @property float|null $lng
 * @property float|null $rating
 * @property int|null $reviews_count
 * @property array|null $price_note
 * @property array|null $working_hours
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $fact_checked_at
 * @property-read City $city
 * @property-read Place|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Place> $children
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 * @property-read Article|null $guideArticle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $media
 */
class Place extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'city_id',
        'parent_id',
        'type',
        'name',
        'slug',
        'description',
        'address',
        'google_maps_url',
        'lat',
        'lng',
        'rating',
        'reviews_count',
        'price_note',
        'working_hours',
        'sort_order',
        'fact_checked_at',
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'name' => 'array',
            'slug' => 'array',
            'description' => 'array',
            'lat' => 'float',
            'lng' => 'float',
            'rating' => 'float',
            'reviews_count' => 'integer',
            'price_note' => 'array',
            'working_hours' => 'array',
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
     * @return BelongsTo<Place, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'parent_id');
    }

    /**
     * @return HasMany<Place, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Place::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * @return HasOne<Article, $this>
     */
    public function guideArticle(): HasOne
    {
        return $this->hasOne(Article::class, 'place_id');
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
