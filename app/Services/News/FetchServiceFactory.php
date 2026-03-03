<?php

namespace App\Services\News;

use App\Enums\NewsSources;
use App\Interfaces\FetchNewsServiceInterface;
use App\ServiceProviders\BBC\FetchNewsService as BBCFetchNewsService;
use App\ServiceProviders\Guardian\FetchNewsService as GuardianFetchNewsService;
use App\ServiceProviders\NewsApi\FetchNewsService as NewsApiFetchNewsService;

class FetchServiceFactory
{
    public function create(NewsSources $source): FetchNewsServiceInterface
    {
        return match ($source) {
            NewsSources::GUARDIAN_API => new GuardianFetchNewsService,
            NewsSources::BBC_API => new BBCFetchNewsService,
            NewsSources::NEWS_API => new NewsApiFetchNewsService
        };
    }
}
