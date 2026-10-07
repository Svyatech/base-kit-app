<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property array $name
 * @property string|null $name_local
 * @property array $slug
 * @property array|null $excerpt
 * @property array|null $content
 * @property array|null $seo_title
 * @property array|null $seo_description
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $sort_order
 * @property float|null $map_lat
 * @property float|null $map_lng
 * @property int|null $map_zoom
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Place> $places
 */
class City extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'name_local',
        'slug',
        'excerpt',
        'content',
        'seo_title',
        'seo_description',
        'is_published',
        'published_at',
        'sort_order',
        'map_lat',
        'map_lng',
        'map_zoom',
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'name' => 'array',
            'slug' => 'array',
            'excerpt' => 'array',
            'content' => 'array',
            'seo_title' => 'array',
            'seo_description' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'map_lat' => 'float',
            'map_lng' => 'float',
        ];
    }

    /**
     * @return HasMany<Article, $this>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return HasMany<Place, $this>
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
