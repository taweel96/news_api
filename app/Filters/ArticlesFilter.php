<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;

class ArticlesFilter extends ModelFilter
{

    public function from_date(string $value){
        return $this->whereDate('published_at', '>=', $value);
    }

    public function to_date(string $value){
        return $this->whereDate('published_at', '<=', $value);
    }

     public function sources(array $value){
        return $this->whereIn('source', $value);
    }

    public function categories(array $value){
        return $this->whereIn('category_id', $value);
    }

}