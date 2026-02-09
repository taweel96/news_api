<?php

namespace App\ServiceProviders\NewsApi;

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

            $configs = config('services.news.news_api');
            $data = Http::get($configs['url'] . '/top-headlines?country=us&apiKey=' . $configs['api_key'])->json();

            $data = $data['articles'];

            $articles = [];

            foreach($data as $item){
                $author = Author::query()->firstOrCreate(['name' => 'unknown']);

                $published_at = Carbon::parse($item['publishedAt']);

                $category = Category::query()->firstOrCreate(['name' => 'general']);

                $description = $item['description'] ?? null;
                if(!empty($item['content'])){
                    if(!empty($description))
                    {
                        $description .= '/n';
                    }
                    $description .= $item['content'];
                }
                $articles [] = Article::query()->updateOrCreate([
                    'link' => $item['url'] ?? null,
                    'source' => NewsSources::NEWS_API->value,
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'title' => $item['title'] ?? null,
                ],[
                    'content' => $description,
                    'image' => $item['urlToImage'] ?? null,
                    'published_at' => $published_at,
                ]);
            }
            return $articles;

        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

}