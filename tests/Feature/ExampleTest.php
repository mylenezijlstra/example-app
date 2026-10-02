<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test that the homepage loads successfully with dynamic posts.
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Laravel From Scratch');
        $response->assertSee('/posts/');
    }

    /**
     * Test that the default post route loads.
     */
    public function test_the_detail_post_page_loads()
    {
        $response = $this->get('/post');

        $response->assertStatus(200);
        $response->assertSee('Back to Posts');
    }

    /**
     * Test that a specific post loads by its slug.
     */
    public function test_the_detail_post_page_loads_with_slug()
    {
        $post = Post::first();

        $response = $this->get('/posts/' . $post->slug);

        $response->assertStatus(200);
        $response->assertSee($post->title);
        $response->assertSee('Back to Posts');
    }

    /**
     * Test filtering posts by category.
     */
    public function test_can_filter_posts_by_category()
    {
        $category = Category::where('slug', 'techniques')->first();
        $matchingPost = Post::where('category_id', $category->id)->first();

        $response = $this->get('/?category=' . $category->slug);

        $response->assertStatus(200);
        $response->assertSee($matchingPost->title);
        $response->assertSee('selected');
    }

    /**
     * Test filtering posts by author in "Other Filters".
     */
    public function test_can_filter_posts_by_author()
    {
        $author = User::where('username', 'lary-laracore')->first();
        $matchingPost = Post::where('user_id', $author->id)->first();

        $response = $this->get('/?author=' . $author->username);

        $response->assertStatus(200);
        $response->assertSee($matchingPost->title);
        $response->assertSee('selected');
    }

    /**
     * Test pagination preserves query string across pages.
     */
    public function test_pagination_preserves_query_string()
    {
        $response = $this->get('/?category=techniques&page=1');

        $response->assertStatus(200);
        // Pagination links contain category query string
        $response->assertSee('category=techniques');
    }

    /**
     * Test that caching operates on post retrieval with pagination.
     */
    public function test_posts_are_cached()
    {
        Cache::flush();

        $this->get('/');

        $cacheKey = 'posts.' . md5(serialize([]) . '.page.1');
        $this->assertTrue(Cache::has($cacheKey));
    }
}
