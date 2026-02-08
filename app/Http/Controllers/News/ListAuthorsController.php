<?php

namespace App\Http\Controllers\News;

use App\Models\Author;
use Illuminate\Http\JsonResponse;

class ListAuthorsController
{

    public function __invoke(): JsonResponse
    {
        return response()->json(["authors" => Author::query()->latest()->get(['id', 'name'])]);
    }

}