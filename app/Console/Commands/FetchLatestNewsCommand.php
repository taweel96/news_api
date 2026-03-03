<?php

namespace App\Console\Commands;

use App\Enums\NewsSources;
use App\Services\News\FetchServiceFactory;
use App\Services\News\ParseNewsApiResponseFactory;
use App\Services\News\UpdateLocalNewsDatasetFactory;
use Illuminate\Console\Command;

class FetchLatestNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-latest-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        protected FetchServiceFactory $fetchServiceFactory,
        protected ParseNewsApiResponseFactory $parseNewsApiResponseFactory,
        protected UpdateLocalNewsDatasetFactory $updateLocalNewsDatasetFactory,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (NewsSources::cases() as $case) {

            $fetchService = $this->fetchServiceFactory->create($case);
            $articles = $fetchService->fetch();

            $parseService = $this->parseNewsApiResponseFactory->create($case);
            $parsedArticles = $parseService->parse($articles);

            $updateLocalNewsDatasetService = $this->updateLocalNewsDatasetFactory->create($case);
            $updateLocalNewsDatasetService->update($parsedArticles);

        }
    }
}
