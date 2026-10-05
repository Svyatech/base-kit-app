<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $city_id
 * @property int|null $place_id
 * @property string $type
 * @property array $title
 * @property array $slug
 * @property array|null $excerpt
 * @property array|null $content
 * @property array|null $faq
 * @property array|null $sources
 * @property array|null $seo_title
 * @property array|null $seo_description
 * @property string $status
 * @property Carbon|null $fact_checked_at
 * @property Carbon|null $published_at
 * @property-read City|null $city
 * @property-read Place|null $place
 * @property-read Collection<int, Place> $places
 * @property-read Collection<int, Persona> $personas
 * @property-read Collection<int, Media> $media
 */
class Article extends Model
{
    /**
     * @var string
     */
    public const TYPE_TOPIC = 'topic';

    /**
     * @var string
     */
    public const TYPE_COMPARISON = 'comparison';

    /**
     * @var string
     */
    public const TYPE_PERSONA_GUIDE = 'persona_guide';

    /**
     * @var string
     */
    public const TYPE_COUNTRY_TOPIC = 'country_topic';

    /**
     * @var string
     */
    public const STATUS_DRAFT = 'draft';

    /**
     * @var string
     */
    public const STATUS_PUBLISHED = 'published';

    /**
     * @var string[]
     */
    protected $fillable = [
        'city_id',
        'place_id',
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

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'title' => 'array',
            'slug' => 'array',
            'excerpt' => 'array',
            'content' => 'array',
            'faq' => 'array',
            'sources' => 'array',
            'seo_title' => 'array',
            'seo_description' => 'array',
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
     * @return BelongsTo<Place, $this>
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
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
