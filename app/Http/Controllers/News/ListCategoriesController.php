<?php

namespace App\Http\Controllers\News;

use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class ListCategoriesController
{

    public function __invoke(): JsonResponse
    {
        return ApiResponse::success(Category::query()->latest()->get(['id', 'name']));
    }

}