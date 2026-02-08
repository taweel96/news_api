<?php

namespace App\Services\News;

use App\Enums\NewsServiceProviders;
use Illuminate\Support\Facades\Http;

class FetchNewsService
{


    private function fetchNewsFromProvider(NewsServiceProviders $provider)
    {
        $configs = config('services.news.'.$provider->value);

        return Http::get($configs['url'])->json();

    }

}