<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Eager load relationships by default to avoid N+1 queries.
     */
    protected $with = ['category', 'author'];

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Invalidate post caches on save or delete.
     */
    protected static function booted()
    {
        static::saved(function ($post) {
            Cache::forget('posts.all');
            Cache::forget("post.{$post->slug}");
        });

        static::deleted(function ($post) {
            Cache::forget('posts.all');
            Cache::forget("post.{$post->slug}");
        });
    }

    /**
     * Query scope to filter posts by search query, category, or author.
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn ($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
            );
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', fn ($query) =>
                $query->where('slug', $category)
            );
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas('author', fn ($query) =>
                $query->where('username', $author)
            );
        });
    }

    /**
     * A post belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A post belongs to an author (user).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
