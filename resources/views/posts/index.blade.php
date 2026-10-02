<x-layout>
    <header class="max-w-xl mx-auto mt-20 text-center">
        <h1 class="text-4xl">
            Latest <span class="text-blue-500">Laravel From Scratch</span> News
        </h1>

        <h2 class="inline-flex mt-2">By Lary Laracore <img src="/images/lary-head.svg"
                                                           alt="Head of Lary the mascot"></h2>

        <p class="text-sm mt-14">
            Another year. Another update. We're refreshing the popular Laravel series with new content.
            I'm going to keep you guys up to speed with what's going on!
        </p>

        <form method="GET" action="/" class="space-y-2 lg:space-y-0 lg:space-x-4 mt-8 flex flex-col lg:flex-row items-center justify-center">
            <!-- Category Filter -->
            <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl w-full lg:w-auto">
                <select name="category" onchange="this.form.submit()" class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <svg class="transform -rotate-90 absolute pointer-events-none" style="right: 12px;" width="22"
                     height="22" viewBox="0 0 22 22">
                    <g fill="none" fill-rule="evenodd">
                        <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z"></path>
                        <path fill="#222"
                              d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>
                    </g>
                </svg>
            </div>

            <!-- Other Filters (Authors) -->
            <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl w-full lg:w-auto">
                <select name="author" onchange="this.form.submit()" class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">
                    <option value="">Other Filters: Authors</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->username }}" {{ request('author') === $author->username ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>

                <svg class="transform -rotate-90 absolute pointer-events-none" style="right: 12px;" width="22"
                     height="22" viewBox="0 0 22 22">
                    <g fill="none" fill-rule="evenodd">
                        <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z"></path>
                        <path fill="#222"
                              d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>
                    </g>
                </svg>
            </div>

            <!-- Search -->
            <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl px-3 py-2 w-full lg:w-auto">
                <input type="text"
                       name="search"
                       placeholder="Find something"
                       value="{{ request('search') }}"
                       class="bg-transparent placeholder-black font-semibold text-sm focus:outline-none">
            </div>

            <!-- Clear filters button -->
            @if (request('category') || request('author') || request('search') || request('sort'))
                <a href="/"
                   class="inline-flex items-center text-xs font-semibold text-gray-500 hover:text-red-500 py-2 px-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors"
                   title="Wis alle actieve filters">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Wis filters
                </a>
            @endif
        </form>
    </header>

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($posts->count())
            <x-posts-grid :posts="$posts" />

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Geen artikelen gevonden voor de gekozen filters.</p>
                <div class="mt-4">
                    <a href="/" class="text-blue-500 hover:underline text-sm font-semibold">Wis filters en toon alles</a>
                </div>
            </div>
        @endif
    </main>
</x-layout>
