<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Author extends Model
{
    //
    protected $fillable = ['name'];
}
