<?php

namespace App\ServiceProviders\BBC;

use App\Interfaces\FetchNewsServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsService implements FetchNewsServiceInterface
{
    public function fetch(): array
    {
        try {
            $configs = config('services.news.bbc');

            return Http::get($configs['url'].'/news?lang=english')->json();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return [];
        }
    }
}
