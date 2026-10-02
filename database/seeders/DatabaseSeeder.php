<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        Category::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $lary = User::create([
            'name' => 'Lary Laracore',
            'username' => 'lary-laracore',
            'email' => 'lary@laracasts.com',
            'password' => bcrypt('password'),
        ]);

        $jeffrey = User::create([
            'name' => 'Jeffrey Way',
            'username' => 'jeffrey-way',
            'email' => 'jeffrey@laracasts.com',
            'password' => bcrypt('password'),
        ]);

        $techniques = Category::create([
            'name' => 'Techniques',
            'slug' => 'techniques',
        ]);

        $updates = Category::create([
            'name' => 'Updates',
            'slug' => 'updates',
        ]);

        $personal = Category::create([
            'name' => 'Personal',
            'slug' => 'personal',
        ]);

        $business = Category::create([
            'name' => 'Business',
            'slug' => 'business',
        ]);

        Post::create([
            'user_id' => $lary->id,
            'category_id' => $techniques->id,
            'title' => 'This is a big title and it will look great on two or even three lines. Wooohoo!',
            'slug' => 'this-is-a-big-title-and-it-will-look-great',
            'thumbnail' => 'images/illustration-1.png',
            'excerpt' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
            'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p><h2 class="font-bold text-lg">Sed quia consequuntur</h2><p>Magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p><p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>',
            'published_at' => now()->subDay(),
        ]);

        Post::create([
            'user_id' => $lary->id,
            'category_id' => $updates->id,
            'title' => 'Getting Started with Modern Laravel Architecture and Blade Components',
            'slug' => 'getting-started-with-modern-laravel-architecture',
            'thumbnail' => 'images/illustration-1.png',
            'excerpt' => '<p>Learn how to structure your modern Laravel applications cleanly using Object-Oriented Principles, reusable Blade layout components, and high-performance caching layers.</p>',
            'body' => '<p>Modern Laravel provides an exceptional developer experience out of the box. By organizing business logic cleanly into dedicated Model classes, Service layers, and Blade components, your code becomes modular and easy to maintain.</p><p>Through Blade layouts and components, you eliminate duplicate HTML code and create consistent UI components effortlessly across your entire platform.</p>',
            'published_at' => now()->subDays(2),
        ]);

        Post::create([
            'user_id' => $jeffrey->id,
            'category_id' => $techniques->id,
            'title' => 'Mastering Database Migrations, Seeders and Factories in Practice',
            'slug' => 'mastering-database-migrations-seeders-factories',
            'thumbnail' => 'images/illustration-2.png',
            'excerpt' => '<p>A deep dive into managing MySQL schemas dynamically using Artisan commands, Model Factories, and Database Seeders for seamless local development.</p>',
            'body' => '<p>Database migrations are like version control for your database, allowing your team to define and share the application’s database schema definition.</p><p>Coupled with Model Factories and Database Seeders, you can spin up a fully working database populated with rich demo data in a matter of seconds using a single command: php artisan migrate:fresh --seed.</p>',
            'published_at' => now()->subDays(3),
        ]);

        Post::create([
            'user_id' => $lary->id,
            'category_id' => $personal->id,
            'title' => 'Speeding up Performance with Smart Cache Strategies in PHP',
            'slug' => 'speeding-up-performance-with-smart-cache-strategies',
            'thumbnail' => 'images/illustration-3.png',
            'excerpt' => '<p>Discover how caching your Eloquent queries and views can dramatically reduce database load and improve response times for high-traffic web apps.</p>',
            'body' => '<p>Caching is one of the most effective ways to make your web application lightning fast. Laravel makes caching effortless with its expressive cache API, supporting file, Redis, Memcached, and database drivers.</p><p>By caching expensive database queries and using model lifecycle hooks to invalidate stale cache entries, your application stays both fast and accurate.</p>',
            'published_at' => now()->subDays(4),
        ]);

        Post::create([
            'user_id' => $jeffrey->id,
            'category_id' => $business->id,
            'title' => 'Building Scalable Web Applications with Clean OOP Design Patterns',
            'slug' => 'building-scalable-web-applications-oop',
            'thumbnail' => 'images/illustration-4.png',
            'excerpt' => '<p>Object-Oriented Programming principles empower developers to craft resilient, maintainable, and testable codebases that stand the test of time.</p>',
            'body' => '<p>Object-Oriented Programming (OOP) allows us to encapsulate state and behavior inside cohesive classes. In Laravel, Eloquent models encapsulate data logic and relationships, while Service classes and Controllers coordinate actions cleanly.</p><p>Following SOLID principles ensures each class has a clear responsibility, keeping the system modular and testable.</p>',
            'published_at' => now()->subDays(5),
        ]);

        Post::create([
            'user_id' => $lary->id,
            'category_id' => $updates->id,
            'title' => 'The Future of Laravel and Modern Full-Stack Development',
            'slug' => 'the-future-of-laravel-full-stack',
            'thumbnail' => 'images/illustration-5.png',
            'excerpt' => '<p>Explore upcoming innovations in the PHP and Laravel ecosystem, from reactive interfaces to modern serverless cloud deployments.</p>',
            'body' => '<p>The PHP and Laravel ecosystems have matured into one of the most powerful and enjoyable web development platforms available today.</p><p>With tools like Artisan, Vite, Blade components, and seamless database integration, you have everything needed to build state-of-the-art web products quickly and efficiently.</p>',
            'published_at' => now()->subDays(6),
        ]);
    }
}
