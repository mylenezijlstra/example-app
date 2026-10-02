<?php

namespace Tests\Feature;

use App\Models\Post;
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
        $post = Post::first();

        $response = $this->get('/?category=' . $post->category->slug);

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    /**
     * Test that caching operates on post retrieval.
     */
    public function test_posts_are_cached()
    {
        Cache::flush();

        $this->get('/');

        $cacheKey = 'posts.' . md5(serialize([]));
        $this->assertTrue(Cache::has($cacheKey));
    }
}
