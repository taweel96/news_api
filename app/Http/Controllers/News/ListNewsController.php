<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\ListNewsRequest;
use App\ServiceProviders\BBC\FetchNewsService;
use Illuminate\Http\Request;

class ListNewsController extends Controller
{

    public function __construct(protected FetchNewsService $listNewsService)
    {

    }
    public function __invoke(ListNewsRequest $request)
    {
        return response()->json($this->listNewsService->fetch());
    }
}
