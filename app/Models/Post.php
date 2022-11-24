<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PostFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int                  $id
 * @property int                  $category_id
 * @property int                  $user_id
 * @property string               $slug
 * @property string               $title
 * @property string|null          $thumbnail
 * @property string               $excerpt
 * @property string               $body
 * @property Carbon|null          $published_at
 * @property Carbon               $created_at
 * @property Carbon               $updated_at
 * @property Category             $category
 * @property User                 $author
 * @property Collection|Comment[] $comments
 *
 * @method static PostFactory factory(...$parameters)
 * @mixin Builder
 */
class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'category_id',
        'user_id',
        'slug',
        'title',
        'thumbnail',
        'excerpt',
        'body',
        'published_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'           => 'int',
        'category_id'  => 'int',
        'user_id'      => 'int',
        'published_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param Builder $query
     * @param array   $filters
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        $query
            ->when($filters['search'] ?? false, fn (Builder $query, $search) => $query
                ->where(fn (Builder $query) => $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
                )
            )
            ->when($filters['category'] ?? false, function (Builder $query, $category) {
                $query->whereRelation('category', 'slug', $category);
            })
            ->when($filters['author'] ?? false, function (Builder $query, $author) {
                $query->whereRelation('author', 'username', $author);
            });
    }
}
