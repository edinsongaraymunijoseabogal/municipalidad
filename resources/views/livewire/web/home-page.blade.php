<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    <!-- Slider de Noticias Destacadas -->
    <section>
        <div id="default-carousel" class="relative w-full bg-white" data-carousel="slide">
            <div class="relative h-56 overflow-hidden md:h-96">
                @foreach ($news as $item)
                    <div class="hidden duration-700 ease-in-out bg-white" data-carousel-item>
                        <img loading="lazy" class="w-full h-full object-cover"
                            src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}">
                    </div>
                @endforeach
            </div>
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-600 group-focus:none">
                    <svg class="w-4 h-4 text-white  rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-600 group-focus:none">
                    <svg class="w-4 h-4 text-white  rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
        <div class="bg-green-600 flex flex-wrap justify-center items-center">
            <!-- Item para el enlace del gobierno -->
            <a href="https://www.gob.pe/munijosesabogal" target="_blank"
                class="text-white transition ease-in-out duration-300 hover:bg-green-800 p-6 flex items-center gap-4 w-full md:w-1/4">
                <div class="flex items-center justify-center bg-white rounded-full h-12 w-12">
                    <i class="fa fa-globe fa-2x text-green-600"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold line-clamp-1">{{ __('Visit Government Site') }}</p>
                    <span class="text-sm line-clamp-1">{{ __('Official government website') }}</span>
                </div>
            </a>

            <!-- Item para Portal de Transparencia -->
            <a href="{{ route('web.documents') }}"
                class="text-white transition ease-in-out duration-300 hover:bg-green-800 p-6 flex items-center gap-4 w-full md:w-1/4">
                <div class="flex items-center justify-center bg-white rounded-full h-12 w-12">
                    <i class="fa fa-balance-scale fa-2x text-green-600"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold line-clamp-1">{{ __('Transparency Portal') }}</p>
                    <span class="text-sm line-clamp-1">{{ __('Access public information') }}</span>
                </div>
            </a>

            <!-- Item para Servicios en Línea -->
            <a href="{{ route('web.contactUs') }}"
                class="text-white transition ease-in-out duration-300 hover:bg-green-800 p-6 flex items-center gap-4 w-full md:w-1/4">
                <div class="flex items-center justify-center bg-white rounded-full h-12 w-12">
                    <i class="fa fa-phone fa-2x text-green-600"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold line-clamp-1">{{ __('Contact Us') }}</p>
                    <span class="text-sm line-clamp-1">{{ __('Just send us your questions or concerns') }}</span>
                </div>
            </a>

            <!-- Item para Noticias y Eventos -->
            <a href="{{ route('web.posts') }}"
                class="text-white transition ease-in-out duration-300 hover:bg-green-800 p-6 flex items-center gap-4 w-full md:w-1/4">
                <div class="flex items-center justify-center bg-white rounded-full h-12 w-12">
                    <i class="fa fa-newspaper fa-2x text-green-600"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold line-clamp-1">{{ __('News & Events') }}</p>
                    <span class="text-sm line-clamp-1">{{ __('Stay informed about local news') }}</span>
                </div>
            </a>
        </div>


    </section>

    <!-- Últimas Noticias -->
    <section>
        <h2 class="text-3xl font-bold mb-6">Últimas Noticias</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($news as $item)
                <div
                    class="bg-white shadow-lg rounded-lg overflow-hidden cursor-pointer transition ease-in-out hover:-translate-y-1 duration-300">
                    <img loading="lazy" class="w-full h-48 object-cover"
                        src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">{{ $item->title }}</h3>
                        <p class="text-gray-600 line-clamp-3">{!! strip_tags(Str::limit($item->content, 150)) !!}</p>
                        <a href="#"
                            class="px-2 py-1 rounded inline-block mt-4 text-sm font-semibold transition ease-in-out bg-green-300 hover:bg-green-500 duration-300">Leer
                            más</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Videos Populares -->
    <section>
        <h2 class="text-3xl font-bold mb-6">{{ __('Popular Videos') }}</h2>
        <div class="flex space-x-2 overflow-x-auto pb-4">
            @foreach ($videos as $video)
                <div class="min-w-[250px] bg-gray-100 border border-gray-200 shadow-lg overflow-hidden cursor-pointer transition ease-in-out hover:-translate-y-1 duration-300"
                    x-data="{ showVideo: false }">
                    <!-- Imagen con Botón de Play -->
                    <template x-if="!showVideo">
                        <div class="relative cursor-pointer" @click="showVideo=true">
                            <img class="w-full h-48 object-cover"
                                src="{{ $video->featured_image ? Storage::url($video->featured_image) : 'https://via.placeholder.com/300x200.png?text=Play+Video' }}"
                                alt="{{ $video->title }}">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white bg-opacity-75 rounded-full px-4 py-2 ">
                                    <i class="fas fa-play text-2xl text-green-600"></i>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Video iframe que se carga al hacer clic -->
                    <template x-if="showVideo">
                        <iframe class="w-full h-48" src="{{ $video->embed_url }}" frameborder="0"
                            allowfullscreen></iframe>
                    </template>

                    <div class="p-4 ">
                        <span class="text-gray-600 text-xs font-semibold">
                            {{ Carbon\Carbon::parse($video->published_at)->format('F j, Y') }}
                        </span>
                        <h3 class="text-sm font-bold mt-2 line-clamp-2">{{ $video->title }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Accesos Directos -->
    <section>
        <h2 class="text-3xl font-bold mb-6">Accesos Directos</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('web.posts') }}"
                class="flex items-center justify-center bg-green-100 p-6 rounded-lg hover:bg-green-200 transition">
                <i class="fas fa-newspaper text-2xl text-green-600"></i>
                <span class="ml-3 font-semibold">{{ __('News') }}</span>
            </a>
            <a href="{{ route('web.videos') }}"
                class="flex items-center justify-center bg-green-100 p-6 rounded-lg hover:bg-green-200 transition">
                <i class="fas fa-video text-2xl text-green-600"></i>
                <span class="ml-3 font-semibold">{{ __('Videos') }}</span>
            </a>
            <a href="{{ route('web.directory') }}"
                class="flex items-center justify-center bg-green-100 p-6 rounded-lg hover:bg-green-200 transition">
                <i class="fas fa-blog text-2xl text-green-600"></i>
                <span class="ml-3 font-semibold">{{ __('Directory') }}</span>
            </a>
            <a href="{{ route('web.contactUs') }}"
                class="flex items-center justify-center bg-green-100 p-6 rounded-lg hover:bg-green-200 transition">
                <i class="fas fa-phone-alt text-2xl text-green-600"></i>
                <span class="ml-3 font-semibold">{{ __('Contact Us') }}</span>
            </a>
        </div>
    </section>

    <!-- Sección de Mapa de Ubicación -->
    <section>
        <h2 class="text-3xl font-bold mb-6">{{ __('Locate Us') }}</h2>
        <livewire:web.location-map />
    </section>
</div>
