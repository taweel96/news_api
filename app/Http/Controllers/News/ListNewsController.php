<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\ListNewsRequest;
use App\Http\Resources\News\ArticleResource;
use App\Services\News\ListNewsService;
use Illuminate\Http\Request;

class ListNewsController extends Controller
{

    public function __construct(protected ListNewsService $listNewsService)
    {

    }
    public function __invoke(ListNewsRequest $request)
    {
        $articles = $this->listNewsService->handle($request);

        return response()->json(ArticleResource::collection($articles));
    }
}
