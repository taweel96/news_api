<?php

namespace App\ServiceProviders\BBC;

use App\Enums\Categories;
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

        $published_at = Carbon::createFromTimestamp($articles['timestamp']);

        unset($articles['status'], $articles['elapsed time'], $articles['timestamp']);

        foreach ($articles as $category => $items) {
            $category = Categories::map($category);

            $category = Category::query()->firstOrCreate(['name' => $category]);

            $author = Author::query()->firstOrCreate(['name' => 'unknown']);

            foreach ($items as $item) {
                $parsedArticles[] = [
                    'category_id' => $category->id,
                    'link' => $item['url'] ?? null,
                    'source' => NewsSources::BBC_API->value,
                    'author_id' => $author->id,
                    'title' => $item['title'] ?? null,
                    'summary' => $item['summary'] ?? null,
                    'content' => $item['content'] ?? null,
                    'image' => $item['image'] ?? null,
                    'published_at' => $published_at,
                ];
            }
        }

        return $parsedArticles;

    }
}
