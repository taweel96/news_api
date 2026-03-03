<?php

namespace App\ServiceProviders\NewsApi;

use App\Interfaces\FetchNewsServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsService implements FetchNewsServiceInterface
{
    public function fetch(): array
    {

        try {

            $configs = config('services.news.news_api');
            $data = Http::get($configs['url'].'/top-headlines?country=us&apiKey='.$configs['api_key'])->json();

            return $data['articles'];

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return [];
        }
    }
}
