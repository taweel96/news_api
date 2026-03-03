<?php

namespace App\Services\News;

use App\Enums\NewsSources;
use App\Interfaces\UpdateLocalNewsDatasetInterface;
use App\ServiceProviders\BBC\UpdateLocalNewsDatasetService as BBCUpdateLocalNewsDatasetService;
use App\ServiceProviders\Guardian\UpdateLocalNewsDatasetService as GuardianUpdateLocalNewsDatasetService;
use App\ServiceProviders\NewsApi\UpdateLocalNewsDatasetService as NewsApiUpdateLocalNewsDatasetService;

class UpdateLocalNewsDatasetFactory
{
    public function create(NewsSources $source): UpdateLocalNewsDatasetInterface
    {
        return match ($source) {
            NewsSources::GUARDIAN_API => app()->make(GuardianUpdateLocalNewsDatasetService::class),
            NewsSources::BBC_API => app()->make(BBCUpdateLocalNewsDatasetService::class),
            NewsSources::NEWS_API => app()->make(NewsApiUpdateLocalNewsDatasetService::class),
        };
    }
}
