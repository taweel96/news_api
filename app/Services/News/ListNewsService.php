<?php

namespace App\Services\News;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ListNewsService
{

    public function handle(Request $request): LengthAwarePaginator
    {
        $user = $request->user();

        $overrides = [];
        if ($request->filled('sources')) {
            $overrides['sources'] = array_filter($request->query('sources'));
        }
        if ($request->filled('categories')) {
            $overrides['categories'] = array_filter($request->query('categories'));
        }
        if ($request->filled('authors')) {
            $overrides['authors'] = array_filter($request->query('authors'));
        }

        $perPage = (int) $request->query('per_page', 15);

        if(request()->filled('query')) {
            $articles = Article::search(request()->query('query'))->orderByDesc('published_at');
        }
        else{
            $articles = Article::query()->with(['category', 'author']);
            if(request()->with_preferences) {
                $articles = $articles->forUser($user, $overrides);
            }
            $articles = $articles->filter($request->validated())->latest('published_at');
        }



        return $articles
            ->paginate($perPage);
    }

}