<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $name_local
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $content
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $sort_order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Place> $places
 */
class City extends Model
{
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
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
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
