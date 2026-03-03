<?php

namespace App\Services\News;

use App\Enums\NewsSources;
use App\Interfaces\ParseApiResponseInterface;
use App\ServiceProviders\BBC\ParseNewsApiResponseService as BBCParseNewsApiResponseService;
use App\ServiceProviders\Guardian\ParseNewsApiResponseService as GuardianParseNewsApiResponseService;
use App\ServiceProviders\NewsApi\ParseNewsApiResponseService as NewsApiParseNewsApiResponseService;

class ParseNewsApiResponseFactory
{
    public static function create(NewsSources $case): ParseApiResponseInterface
    {
        return match ($case) {
            NewsSources::GUARDIAN_API => app()->make(GuardianParseNewsApiResponseService::class),
            NewsSources::BBC_API => app()->make(BBCParseNewsApiResponseService::class),
            NewsSources::NEWS_API => app()->make(NewsApiParseNewsApiResponseService::class),
        };
    }
}
