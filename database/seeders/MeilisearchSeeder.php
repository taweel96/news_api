<?php

namespace Database\Seeders;

use Meilisearch\Client;
use Illuminate\Database\Seeder;

class MeilisearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $client = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );

        $client->index('articles')->updateSettings([
            'sortableAttributes' => ['published_at'],
        ]);
    }
}
