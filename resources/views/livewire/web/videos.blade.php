<div class="max-w-7xl mx-auto pb-8 px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Sección de Video Destacado -->
    @if ($featured)
        <section x-data="{ showVideo: false }">
            <div class="relative bg-gray-100 overflow-hidden border border-gray-200 shadow-lg cursor-pointer h-96"
                @click="showVideo=true">
                <template x-if="!showVideo">
                    <div class="relative">
                        <img loading="lazy" class="w-full h-96 object-cover"
                            src="{{ $featured->featured_image ? Storage::url($featured->featured_image) : 'https://via.placeholder.com/300x200.png?text=Play+Video' }}"
                            alt="{{ $featured->title }}">
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-full px-4 py-2 ">
                                <i class="fas fa-play text-4xl text-green-600"></i>
                            </div>
                        </div>
                        <div
                            class="absolute top-0 bottom-0 p-4 bg-gradient-to-t from-black via-transparent to-transparent text-white w-full content-end">
                            <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1">
                                {{ Carbon\Carbon::parse($featured->published_at)->format('F j, Y') }}
                            </span>
                            <h3 class="text-lg font-bold mt-2 line-clamp-2">{{ $featured->title }}</h3>
                        </div>
                    </div>
                </template>
                <template x-if="showVideo">
                    <iframe class="w-full h-96 z-1" src="{{ $featured->embed_url }}" frameborder="0"
                        allowfullscreen></iframe>
                </template>

            </div>
        </section>
    @endif

    <!-- Sección de Videos Populares (scroll tipo carousel) -->
    @if ($mostPopular && $mostPopular->count())
        <section>
            <h2 class="text-2xl font-bold mb-4">{{ __('Most Popular Videos') }}</h2>
            <div class="flex space-x-2 overflow-x-scroll pb-4 scrollbar-hide" style="scroll-snap-type: x mandatory;">
                @foreach ($mostPopular as $video)
                    <div class="min-w-[300px] bg-white border border-gray-200 rounded overflow-hidden"
                        x-data="{ showVideo: false }" style="scroll-snap-align: start;">
                        <template x-if="!showVideo">
                            <img @click="showVideo=true" class="cursor-pointer w-full h-48 object-cover"
                                src="{{ $video->featured_image ? Storage::url($video->featured_image) : 'https://via.placeholder.com/300x200.png?text=Play+Video' }}"
                                alt="{{ $video->title }}">
                        </template>
                        <template x-if="showVideo">
                            <iframe class="w-full h-48" src="{{ $video->embed_url }}" frameborder="0"
                                allowfullscreen></iframe>
                        </template>
                        <div class="p-4">
                            <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1">
                                {{ Carbon\Carbon::parse($video->published_at)->format('F j, Y') }}
                            </span>
                            <h3 class="text-md font-bold mt-2 line-clamp-2">{{ $video->title }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Layout con filtros a la izquierda y videos a la derecha -->
    <div class="lg:flex lg:space-x-4 bg-white rounded py-4 px-2">
        <!-- Filtros en el Aside -->
        <aside class="space-y-6">
            <!-- Filtros agrupados para pantallas pequeñas (apilados) y grandes (juntos) -->
            <div class="p-6 border rounded">
                <div class="grid grid-cols-1 lg:gap-6 gap-2 lg:grid-cols-1">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold mb-4">{{ __('Search Videos') }}</h3>
                        <div class="relative">
                            <input type="text" wire:model.live="search" placeholder="{{ __('Search...') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300 ease-in-out">
                            <div class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Selectores (Categoría y Año) -->
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                        <div>
                            <h3 class="text-lg font-bold mb-4">{{ __('Category') }}</h3>
                            <select wire:model.live="selectedCategory"
                                class="w-full border border-gray-300 rounded-lg py-2 px-4">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-4">{{ __('Year') }}</h3>
                            <select wire:model.live="selectedYear"
                                class="w-full border border-gray-300 rounded-lg py-2 px-4">
                                <option value="">{{ __('All Years') }}</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sección de Todos los Videos en un grid -->
        <div class="lg:w-3/4 space-y-4">
            @if ($videos && $videos->count())
                <section>
                    <h2 class="text-2xl font-bold mb-4">{{ __('All Videos') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($videos as $video)
                            <div class=" border rounded overflow-hidden" x-data="{ showVideo: false }">
                                <template x-if="!showVideo">
                                    <div class="relative" @click="showVideo=true">
                                        <img loading="lazy" class="w-full h-48 object-cover"
                                            src="{{ $video->featured_image ? Storage::url($video->featured_image) : 'https://via.placeholder.com/300x200.png?text=Play+Video' }}"
                                            alt="{{ $video->title }}">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                            <div class="bg-white rounded-full px-4 py-2 ">
                                                <i class="fas fa-play text-2xl text-green-600"></i>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="showVideo">
                                    <iframe class="w-full h-48" src="{{ $video->embed_url }}" frameborder="0"
                                        allowfullscreen></iframe>
                                </template>
                                <div class="p-4">
                                    <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1">
                                        {{ Carbon\Carbon::parse($video->published_at)->format('F j, Y') }}
                                    </span>
                                    <h3 class="text-sm font-bold mt-2 line-clamp-2">{{ $video->title }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @else
                <div class="p-8 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20 10 10 0 010-20z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ __('No videos found') }}</h3>
                    <p class="text-gray-500 mt-2">
                        {{ __('It seems there are no videos matching your current filters. Try adjusting your search or check back later for new content.') }}
                    </p>
                    <div class="mt-6">
                        <button wire:click="resetFilters"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                            {{ __('Reset Filters') }}
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
