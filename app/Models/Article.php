<?php

namespace App\Models;

use App\Enums\NewsSources;
use App\Filters\ArticlesFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


/**
 * @property int $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string|null $image
 * @property int $category_id
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property NewsSources $source
 * @property int|null $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property ?Author $author
 * @property ?Category $category
 */

class Article extends Model
{
    use Filterable;

    protected $fillable = [
        'title', 'summary', 'content', 'image', 'category_id', 'link', 'published_at', 'source', 'author_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'source' => NewsSources::class,
    ];


    public function modelFilter(): string
    {
        return $this->provideFilter(ArticlesFilter::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * @param Builder $query
     * @param \App\Models\User|array|null $userOrPrefs
     * @param array $overrides
     * @return Builder
     */
    public function scopeForUser(Builder $query, $userOrPrefs = null, array $overrides = []): Builder
    {
        $prefs = [];
        if ($userOrPrefs instanceof \App\Models\User) {
            $prefs = [
                'preferred_sources' => $userOrPrefs->sources->pluck('source')->toArray() ?? [],
                'preferred_categories' => $userOrPrefs->categories->pluck('category_id')->toArray() ?? [],
                'preferred_authors' => $userOrPrefs->authors->pluck('author_id')->toArray() ?? [],
            ];
        } elseif (is_array($userOrPrefs)) {
            $prefs = [
                'preferred_sources' => $userOrPrefs['preferred_sources'] ?? $userOrPrefs['sources'] ?? [],
                'preferred_categories' => $userOrPrefs['preferred_categories'] ?? $userOrPrefs['categories'] ?? [],
                'preferred_authors' => $userOrPrefs['preferred_authors'] ?? $userOrPrefs['authors'] ?? [],
            ];
        }

        $sources = $overrides['sources'] ?? $prefs['preferred_sources'] ?? [];
        $categories = $overrides['categories'] ?? $prefs['preferred_categories'] ?? [];
        $authors = $overrides['authors'] ?? $prefs['preferred_authors'] ?? [];

        if (!empty($sources)) {
            $query->whereIn('source', $sources);
        }

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if (!empty($authors)) {
            $query->whereIn('author_id', $authors);
        }

        return $query;
    }
}
