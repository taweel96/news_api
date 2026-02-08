<?php

namespace App\Http\Resources\News;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Article
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'source' => $this->source,
            'author' => AuthorResource::make($this->author),
            'category' => CategoryResource::make($this->category),
            'title' => $this->title,
            'content' => $this->content,
            'link' => $this->link,
            'url_to_image' => $this->image,
            'published_at' => $this->published_at->timestamp,
        ];
    }
}
