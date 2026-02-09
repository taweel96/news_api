<?php

namespace App\ServiceProviders\BBC;

use App\Enums\Categories;
use App\Enums\NewsSources;
use App\Interfaces\FetchNewsServiceInterface;
use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsService implements FetchNewsServiceInterface
{

    public function fetch(): array
    {
        try {
            $configs = config('services.news.bbc');

            $data = Http::get($configs['url'] . '/news?lang=english')->json();

            $articles = [];

            $published_at = Carbon::createFromTimestamp($data['timestamp']);

            unset($data['status'], $data['elapsed time'], $data['timestamp']);

            foreach($data as $category => $items){
                $category = Categories::map($category);

                $category = Category::query()->firstOrCreate(['name' => $category]);

                $author = Author::query()->firstOrCreate(['name' => 'unknown']);

                foreach($items as $item){
                    $articles [] = Article::query()->updateOrCreate([
                        'category_id' => $category->id,
                        'link' => $item['url'] ?? null,
                        'source' => NewsSources::BBC_API->value,
                        'author_id' => $author->id,
                        'title' => $item['title'] ?? null,
                    ],[
                        'summary' => $item['summary'] ?? null,
                        'content' => $item['content'] ?? null,
                        'image' => $item['image'] ?? null,
                        'published_at' => $published_at,
                    ]);
                }
            }
            return $articles;
        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

}