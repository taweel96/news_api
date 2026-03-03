<?php

namespace App\ServiceProviders\Guardian;

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
                'source' => $article['source'],
                'author_id' => $article['author_id'],
                'title' => $article['title'] ?? null,
            ], [
                'summary' => $article['summary'] ?? null,
                'content' => $article['content'] ?? null,
                'image' => $article['image'] ?? null,
                'published_at' => $article['published_at'] ?? null,
            ]);
        }
    }
}
