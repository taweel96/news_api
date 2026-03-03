<?php

namespace App\ServiceProviders\Guardian;

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
        foreach ($articles as $article) {
            $category = Categories::map($article['sectionId']);

            $category = Category::query()->firstOrCreate(['name' => $category]);

            $published_at = Carbon::parse($article['webPublicationDate']);

            $author = Author::query()->firstOrCreate(['name' => 'unknown']);
            $parsedArticles[] = [
                'title' => $article['webTitle'] ?? null,
                'link' => $article['webUrl'] ?? null,
                'source' => NewsSources::GUARDIAN_API->value,
                'published_at' => $published_at,
                'category_id' => $category->id,
                'author_id' => $author->id,
            ];
        }

        return $parsedArticles;

    }
}
