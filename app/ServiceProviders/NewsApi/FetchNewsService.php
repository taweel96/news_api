<?php

namespace App\ServiceProviders\NewsApi;

use App\Enums\Categories;
use App\Enums\NewsServiceProviders;
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
                $authorId = null;
                if(!empty($item['author'])){
                    $author = Author::query()->firstOrCreate(['name' => $item['author']]);
                    $authorId = $author->id;
                }

                $published_at = Carbon::parse($item['publishedAt']);

                $description = $item['description'] ?? null;
                if(!empty($item['content'])){
                    if(!empty($description))
                    {
                        $description .= '/n';
                    }
                    $description .= $item['content'];
                }
                $articles [] = Article::query()->updateOrCreate([
                    'title' => $item['title'] ?? null,
                    'link' => $item['url'] ?? null,
                    'source' => NewsServiceProviders::NEWS_API->value,
                ],[
                    'content' => $description,
                    'image' => $item['urlToImage'] ?? null,
                    'published_at' => $published_at,
                    'author_id' => $authorId,
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