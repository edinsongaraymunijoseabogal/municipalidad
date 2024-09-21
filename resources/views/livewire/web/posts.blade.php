<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-1">
        <div class="lg:col-span-6" x-data x-init="$el.style.opacity = 0;
        setTimeout(() => $el.style.opacity = 1, 300)" style="transition: opacity 0.5s;">
            <h2 class="text-xl font-bold mb-4">{{ __('Featured News') }}</h2>
            @if ($featured)
                <div class="relative bg-gray-100 overflow-hidden border border-gray-200">
                    <img class="w-full h-96 object-cover"
                        src="{{ Storage::url($featured->featured_image) ?? 'https://via.placeholder.com/150x100' }}"
                        alt="{{ $featured->title }}">
                    <div
                        class="absolute top-0 bottom-0 p-4 bg-gradient-to-t from-black via-transparent to-transparent text-white w-full content-end">
                        <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1">
                            {{ Carbon\Carbon::parse($featured->published_at)->format('F j, Y') }}
                        </span>
                        <h3 class="text-lg font-bold mt-2 line-clamp-2">{{ $featured->title }}</h3>
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-3" x-data x-init="$el.style.opacity = 0;
        setTimeout(() => $el.style.opacity = 1, 300)" style="transition: opacity 0.5s;">
            <h2 class="text-xl font-bold mb-4">{{ __('Most Popular') }}</h2>
            <div class="space-y-1">
                @forelse ($mostPopular as $post)
                    <div class="relative bg-gray-100 overflow-hidden border border-gray-200" x-data x-transition>
                        <img class="w-full h-48 object-cover"
                            src="{{ Storage::url($post->featured_image) ?? 'https://via.placeholder.com/150x100' }}"
                            alt="{{ $post->title }}">
                        <div
                            class="absolute top-0 bottom-0 p-4 bg-gradient-to-t from-black via-transparent to-transparent text-white w-full content-end">
                            <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1">
                                {{ Carbon\Carbon::parse($post->published_at)->format('F j, Y') }}
                            </span>
                            <h3 class="text-md font-bold mt-2 line-clamp-2">{{ $post->title }}</h3>
                            <p class="text-xs mt-2 font-bold uppercase">{{ $post->category->name }}</p>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-3" x-data x-init="$el.style.opacity = 0;
        setTimeout(() => $el.style.opacity = 1, 300)" style="transition: opacity 0.5s;">
            <h2 class="text-xl font-bold mb-4">{{ __('Trending') }}</h2>
            <div class="space-y-1">
                @forelse ($trending as $post)
                    <div class="flex items-center bg-white overflow-hidden border  rounded-lg px-2 shadow">
                        <img class="w-24 h-16 object-cover"
                            src="{{ Storage::url($post->featured_image) ?? 'https://via.placeholder.com/150x100' }}"
                            alt="{{ $post->title }}">
                        <div class="px-1 py-4">
                            <h3 class="text-sm font-bold line-clamp-2">{{ $post->title }}</h3>
                            <span class="mt-2 text-gray-500 text-xs font-semibold">
                                {{ Carbon\Carbon::parse($post->published_at)->format('F j, Y') }}
                            </span>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>

    <div>
        @if ($search || $selectedCategory || $selectedYear)
            <p class="text-lg font-semibold text-gray-700">
                {{ __('Results for') }}
                @if ($search)
                    "<span class="text-green-600">{{ $search }}</span>"
                @endif

                @if ($selectedCategory)
                    {{ __('of') }} "<span
                        class="text-green-600">{{ $categories->find($selectedCategory)->name }}</span>"
                @endif

                @if ($selectedYear)
                    {{ __('of the year') }} "<span class="text-green-600">{{ $selectedYear }}</span>"
                @endif
            </p>
        @else
            <h2 class="text-xl font-bold mb-4">{{ __('Latest News') }}</h2>
        @endif
    </div>

    <div>
        <div class="flex overflow-x-auto space-x-2 scrollbar-hide">
            @foreach ($years as $year)
                <a href="#" wire:click.prevent="toggleYear({{ $year }})"
                    class="px-4 py-2 border rounded-lg whitespace-nowrap transition duration-300 ease-in-out font-semibold
                        {{ $selectedYear == $year ? 'bg-green-600 text-white' : 'bg-white text-gray-800 hover:bg-green-600 hover:text-white' }}">
                    {{ $year }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4" x-data x-transition>
            @if ($posts->isEmpty())
                <div class="flex flex-col items-center justify-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 11a4 4 0 118 0 4 4 0 01-8 0zm11 4l-4-4m-2 0H3m6 0H3m6-4V3m0 12v5" />
                    </svg>
                    <p class="text-lg font-semibold text-gray-700">{{ __('No posts found') }}</p>
                    <p class="text-gray-500">{{ __('Try adjusting your search or try other keywords.') }}</p>
                    <a href="#" wire:click.prevent="resetFilters"
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        {{ __('Show All') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($posts as $post)
                        <div class="col-span-1 bg-white border border-gray-200 rounded-lg overflow-hidden pb-4" x-data
                            x-transition>
                            <div class="relative">
                                <img x-data x-init="$el.style.opacity = 0;
                                setTimeout(() => $el.style.opacity = 1, 300)" style="transition: opacity 0.5s;"
                                    class="w-full h-64 object-cover"
                                    src="{{ Storage::url($post->featured_image) ?? 'https://via.placeholder.com/150x100' }}"
                                    alt="{{ $post->title }}">
                                <div
                                    class="absolute top-2 right-2 bg-black bg-opacity-60 text-white text-xs font-semibold px-3 py-1 rounded-lg">
                                    <i class="fa fa-eye mr-1"></i>{{ $post->views }} {{ __('views') }}
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                                    <span
                                        class="text-green-600 uppercase text-sm font-medium">{{ Carbon\Carbon::parse($post->published_at)->format('j F Y') }}</span>
                                    <span class="text-gray-600 font-medium">ADMIN</span>
                                </div>
                                <h3 class="text-lg font-bold mb-2 line-clamp-2">{{ $post->title }}</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{!! strip_tags(Str::limit($post->content, 150)) !!}</p>
                            </div>
                            <hr>
                        </div>
                    @empty
                    @endforelse
                </div>
            @endif
        </div>

        <div class="lg:col-span-1 space-y-2" x-data x-transition>
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold mb-4">{{ __('Search') }}</h3>
                <div class="relative">
                    <input type="text" wire:model.live="search" placeholder="{{ __('Search...') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300 ease-in-out">
                    <button prevent
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded-full transition duration-300 ease-in-out">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ __('Categories') }}</h3>
                <ul class="space-y-3">
                    @foreach ($categories as $index => $category)
                        <li>
                            <a href="#" wire:click.prevent="toggleCategory({{ $category->id }})"
                                class="flex items-center p-4 rounded-lg transition duration-300 ease-in-out 
                                {{ $selectedCategory == $category->id ? 'bg-green-100' : 'bg-gray-50 hover:bg-gray-100' }}">
                                <div
                                    class="flex-shrink-0 bg-green-500 text-white w-8 h-8 flex items-center justify-center rounded-full font-semibold mr-4">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <span class="font-semibold text-gray-800">{{ $category->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
