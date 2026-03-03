<?php

namespace App\ServiceProviders\Guardian;

use App\Interfaces\FetchNewsServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsService implements FetchNewsServiceInterface
{
    public function fetch(): array
    {
        try {

            $configs = config('services.news.the_guardian');

            $data = Http::get($configs['url'].'/search?api-key='.$configs['api_key'])->json();

            return $data['response']['results'];
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return [];
        }
    }
}
