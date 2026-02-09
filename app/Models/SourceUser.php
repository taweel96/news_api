<?php

namespace App\Models;

use App\Enums\NewsSources;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property NewsSources $source
 * @property User $user
 */
class SourceUser extends Model
{
    protected $table = 'sources_users';
    protected $fillable = ['source', 'user_id'];

    protected $casts = [
        'source' => NewsSources::class,
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
