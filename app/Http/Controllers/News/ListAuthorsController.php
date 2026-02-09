<?php

namespace App\Http\Controllers\News;

use App\Models\Author;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ListAuthorsController
{

    public function __invoke(): JsonResponse
    {
        return ApiResponse::success(Author::query()->latest()->get(['id', 'name']));
    }

}