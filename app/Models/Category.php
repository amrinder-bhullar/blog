<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int               $id
 * @property int               $name
 * @property int               $slug
 * @property Carbon            $created_at
 * @property Carbon            $updated_at
 * @property Collection|Post[] $posts
 *
 * @method static CategoryFactory factory(...$parameters)
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
