<?php

namespace App\Models;

use App\Enums\NewsSources;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Collection<Category> $categories
 * @property array<NewsSources> $newsSources
 * @property Collection<Author> $authors
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'categories_users');
    }

    public function authors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'authors_users');
    }

    public function newsSourceRecords()
    {
        return $this->hasMany(SourceUser::class);
    }

    public function getNewsSourcesAttribute(): array
    {
        return $this->newsSourceRecords
            ->map(fn ($row) => $row->source->value)
            ->all();
    }

    public function attachNewsSource($source): void
    {
        if(is_string($source)) {
            $source = NewsSources::from($source);
        }
        $this->newsSourceRecords()->firstOrCreate([
            'source' => $source->value,
        ]);
    }

    public function hasNewsSource(NewsSources $source): bool
    {
        return $this->newsSourceRecords()
            ->where('source', $source->value)
            ->exists();
    }
}
