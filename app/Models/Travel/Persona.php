<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $slug
 * @property array $name
 * @property array|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 */
class Persona extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
        ];
    }

    /**
     * @return BelongsToMany<Article, $this>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
