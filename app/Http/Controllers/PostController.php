<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * The post service instance.
     */
    protected PostService $postService;

    /**
     * Create a new controller instance using OOP dependency injection.
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display the blog posts overview homepage.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category', 'author']);
        $posts = $this->postService->getFilteredPosts($filters);
        $categories = $this->postService->getCategories();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'currentCategory' => $request->get('category'),
        ]);
    }

    /**
     * Display a specific blog post by slug.
     */
    public function show(string $slug): View
    {
        $post = $this->postService->getPostBySlug($slug);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Fallback for /post route to display the featured/latest post.
     */
    public function defaultPost(): View
    {
        $latestPost = Post::latest('published_at')->firstOrFail();

        return $this->show($latestPost->slug);
    }
}
