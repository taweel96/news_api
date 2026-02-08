<?php

namespace App\Interfaces;

use App\Models\Article;

interface FetchNewsServiceInterface
{

    public function fetch(): array;

}