<?php

namespace App\Http\Controllers\News;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class ListCategoriesController
{

    public function __invoke(): JsonResponse
    {
        return response()->json(["categories" => Category::query()->latest()->get(['id', 'name'])]);
    }

}