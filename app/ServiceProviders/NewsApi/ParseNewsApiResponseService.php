<?php

namespace App\ServiceProviders\NewsApi;

use App\Enums\NewsSources;
use App\Interfaces\ParseApiResponseInterface;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Carbon;

class ParseNewsApiResponseService implements ParseApiResponseInterface
{
    public function parse(array $articles): array
    {
        $parsedArticles = [];

        foreach ($articles as $item) {
            $author = Author::query()->firstOrCreate(['name' => 'unknown']);

            $published_at = Carbon::parse($item['publishedAt']);

            $category = Category::query()->firstOrCreate(['name' => 'general']);

            $description = $item['description'] ?? null;
            if (! empty($item['content'])) {
                if (! empty($description)) {
                    $description .= '/n';
                }
                $description .= $item['content'];
            }
            $parsedArticles[] = [
                'link' => $item['url'] ?? null,
                'source' => NewsSources::NEWS_API->value,
                'author_id' => $author->id,
                'category_id' => $category->id,
                'title' => $item['title'] ?? null,
                'content' => $description,
                'image' => $item['urlToImage'] ?? null,
                'published_at' => $published_at,
            ];
        }

        return $parsedArticles;

    }
}
