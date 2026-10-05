<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property int|null $city_id
 * @property string $type
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $content
 * @property array|null $faq
 * @property array|null $sources
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $fact_checked_at
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property-read City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Place> $places
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Persona> $personas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $media
 */
class Article extends Model
{
    public const TYPE_TOPIC = 'topic';
    public const TYPE_COMPARISON = 'comparison';
    public const TYPE_PERSONA_GUIDE = 'persona_guide';
    public const TYPE_COUNTRY_TOPIC = 'country_topic';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'city_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'faq',
        'sources',
        'seo_title',
        'seo_description',
        'status',
        'fact_checked_at',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'faq' => 'array',
            'sources' => 'array',
            'fact_checked_at' => 'date',
            'published_at' => 'datetime',
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
     * @return BelongsToMany<Place, $this>
     */
    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class)->withPivot('sort_order')->orderByPivot('sort_order');
    }

    /**
     * @return BelongsToMany<Persona, $this>
     */
    public function personas(): BelongsToMany
    {
        return $this->belongsToMany(Persona::class);
    }

    /**
     * @return MorphMany<Media, $this>
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('sort_order');
    }
}
