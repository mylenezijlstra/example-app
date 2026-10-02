<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Laravel From Scratch');
        $response->assertSee('/post');
    }

    public function test_the_detail_post_page_loads()
    {
        $response = $this->get('/post');

        $response->assertStatus(200);
        $response->assertSee('Back to Posts');
    }

    public function test_the_detail_post_page_loads_with_slug()
    {
        $response = $this->get('/posts/my-first-post');

        $response->assertStatus(200);
        $response->assertSee('Back to Posts');
    }
}
