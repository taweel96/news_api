<?php

namespace App\ServiceProviders\Guardian;

use App\Enums\Categories;
use App\Enums\NewsServiceProviders;
use App\Interfaces\FetchNewsServiceInterface;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsService implements FetchNewsServiceInterface
{

    public function fetch(): array
    {
        try {

            $configs = config('services.news.the_guardian');

            $data = Http::get($configs['url'] . '/search?api-key=' . $configs['api_key'])->json();

            $data = $data['response']['results'];

            $articles = [];

            foreach($data as $item){
                $category = Categories::map($item['sectionId']);

                $category = Category::query()->firstOrCreate(['name' => $category]);

                $published_at = Carbon::parse($item['webPublicationDate']);

                $articles [] = Article::query()->updateOrCreate([
                    'category_id' => $category->id,
                    'title' => $item['webTitle'] ?? null,
                    'link' => $item['webUrl'] ?? null,
                ],[
                    'source' => NewsServiceProviders::GUARDIAN_API->value,
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