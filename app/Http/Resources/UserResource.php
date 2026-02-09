<?php

namespace App\Http\Resources;

use App\Http\Resources\News\AuthorResource;
use App\Http\Resources\News\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'preferred_sources' => $this->newsSources,
            'preferred_categories' => CategoryResource::collection($this->categories),
            'preferred_authors' => AuthorResource::collection($this->authors),
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];
    }
}
