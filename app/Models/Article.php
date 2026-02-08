<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'title', 'summary', 'content', 'image', 'category_id', 'link', 'published_at', 'source', 'author_id'
    ];
}
