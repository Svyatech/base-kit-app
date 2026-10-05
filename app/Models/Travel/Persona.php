<?php

namespace App\Models\Travel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string|null $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Article> $articles
 */
class Persona extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    /**
     * @return BelongsToMany<Article, $this>
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
