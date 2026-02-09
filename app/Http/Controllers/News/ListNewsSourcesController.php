<?php

namespace App\Http\Controllers\News;

use App\Enums\NewsSources;
use App\Http\Controllers\Controller;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class ListNewsSourcesController extends Controller
{

    public function __invoke(Request $request)
    {
        return ApiResponse::success(NewsSources::cases());
    }
}
