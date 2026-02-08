<?php

namespace App\Console\Commands;

use App\Enums\NewsServiceProviders;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (NewsServiceProviders::cases() as $case) {
            $case->getFetchService()->fetch();
        }
    }
}
