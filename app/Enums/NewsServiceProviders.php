<?php

namespace App\Enums;

use App\Interfaces\FetchNewsServiceInterface;
use App\ServiceProviders\BBC\FetchNewsService as BBCFetchNewsService;
use App\ServiceProviders\Guardian\FetchNewsService as GuardianFetchNewsService;
use App\ServiceProviders\NewsApi\FetchNewsService as NewsApiFetchNewsService;


enum NewsServiceProviders: string
{
    case NEWS_API = 'news_api';

    case GUARDIAN_API = 'guardian_api';

    case BBC_API = 'bbc_api';


    public function getFetchService(): FetchNewsServiceInterface
    {
        return match ($this) {
            self::GUARDIAN_API => new GuardianFetchNewsService(),
            self::BBC_API => new BBCFetchNewsService(),
            self::NEWS_API => new NewsApiFetchNewsService()
        };
    }
}
