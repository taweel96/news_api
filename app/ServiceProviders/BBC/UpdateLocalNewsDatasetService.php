<?php

namespace App\ServiceProviders\BBC;

use App\Interfaces\UpdateLocalNewsDatasetInterface;
use App\Models\Article;

class UpdateLocalNewsDatasetService implements UpdateLocalNewsDatasetInterface
{
    public function update(array $articles): void
    {
        foreach ($articles as $article) {
            Article::query()->updateOrCreate([
                'category_id' => $article['category_id'],
                'link' => $article['link'] ?? null,
                'author_id' => $article['author_id'],
                'title' => $article['title'] ?? null,
                'source' => $article['source'],
            ], [
                'published_at' => $article['published_at'] ?? null,
            ]);
        }
    }
}
