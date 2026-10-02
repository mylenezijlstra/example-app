<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * Retrieve all posts matching the provided filters with pagination, utilizing Cache.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFilteredPosts(array $filters = [], int $perPage = 6): LengthAwarePaginator
    {
        $page = request()->query('page', 1);
        $cacheKey = 'posts.' . md5(serialize($filters) . ".page.{$page}");

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($filters, $perPage) {
            return Post::filter($filters)
                ->with(['category', 'author'])
                ->paginate($perPage)
                ->withQueryString();
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
     * Retrieve all authors for filters, utilizing Cache.
     *
     * @return Collection
     */
    public function getAuthors(): Collection
    {
        return Cache::remember('authors.all', self::CACHE_TTL, function () {
            return User::all();
        });
    }

    /**
     * Clear all post, category, and author caches.
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
