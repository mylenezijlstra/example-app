<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Service class responsible for Post business logic, data retrieval, and caching.
 */
class PostService
{
    /**
     * Cache duration in seconds (10 minutes).
     */
    protected const CACHE_TTL = 600;

    /**
     * Retrieve all posts matching the provided filters, utilizing Cache.
     *
     * @param array $filters
     * @return Collection
     */
    public function getFilteredPosts(array $filters = []): Collection
    {
        $cacheKey = 'posts.' . md5(serialize($filters));

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($filters) {
            return Post::latest('published_at')
                ->filter($filters)
                ->with(['category', 'author'])
                ->get();
        });
    }

    /**
     * Retrieve a specific post by its slug, utilizing Cache.
     *
     * @param string $slug
     * @return Post
     */
    public function getPostBySlug(string $slug): Post
    {
        $cacheKey = "post.{$slug}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($slug) {
            return Post::where('slug', $slug)
                ->with(['category', 'author'])
                ->firstOrFail();
        });
    }

    /**
     * Retrieve all categories for filters, utilizing Cache.
     *
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return Cache::remember('categories.all', self::CACHE_TTL, function () {
            return Category::all();
        });
    }

    /**
     * Clear all post and category caches.
     */
    public function clearCache(): void
    {
        Cache::forget('categories.all');
        Cache::forget('posts.all');
    }
}
