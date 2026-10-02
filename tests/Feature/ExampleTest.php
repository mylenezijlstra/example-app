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
        $response->assertSee('category=techniques');
    }

    /**
     * Test that searching by title returns matching posts.
     */
    public function test_can_search_posts_by_title()
    {
        $response = $this->get('/?search=Scalable');

        $response->assertStatus(200);
        $response->assertSee('Scalable');
        $response->assertSee('value="Scalable"', false);
    }

    /**
     * Test that searching by body text returns matching posts.
     */
    public function test_can_search_posts_by_body()
    {
        $response = $this->get('/?search=SOLID');

        $response->assertStatus(200);
        $response->assertSee('Building');
        $response->assertSee('OOP');
    }

    /**
     * Test that search works together with category filter without leaking across filters.
     */
    public function test_search_and_category_filter_work_together()
    {
        // "Scalable" is in business category
        $response = $this->get('/?category=business&search=Scalable');
        $response->assertStatus(200);
        $response->assertSee('Scalable');

        // Searching for "Scalable" in personal category should return no results
        $responseMismatched = $this->get('/?category=personal&search=Scalable');
        $responseMismatched->assertStatus(200);
        $responseMismatched->assertSee('Geen resultaten gevonden voor', false);
    }

    /**
     * Test clear message when zero results are found.
     */
    public function test_empty_search_shows_clear_message()
    {
        $response = $this->get('/?search=nonexistentkeywordxyz');

        $response->assertStatus(200);
        $response->assertSee('Geen resultaten gevonden voor', false);
        $response->assertSee('nonexistentkeywordxyz', false);
        $response->assertSee('value="nonexistentkeywordxyz"', false);
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
