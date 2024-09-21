<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <section class="mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div class="w-full h-full flex justify-center opacity-0 transform translate-x-10 transition duration-1000 ease-out order-1 lg:order-2"
                x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-x-0')"
                x-intersect:leave="$el.classList.remove('opacity-100', 'translate-x-0')">
                <img src="{{ Storage::url($about_us_image) }}" alt="{{ app('configService')->get('site_title') }}"
                    class="rounded-lg w-full object-cover {{ pathinfo($about_us_image, PATHINFO_EXTENSION) == 'png' ? 'filter drop-shadow-lg' : 'shadow-lg' }}">
            </div>

            <div x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-x-0')"
                x-intersect:leave="$el.classList.remove('opacity-100', 'translate-x-0')"
                class="opacity-0 transform translate-x-10 transition duration-1000 ease-out order-2 lg:order-1">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>{{ __('Sobre Nosotros') }}
                </h1>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed mb-4">{{ $about_us_text }}</p>
            </div>
        </div>
    </section>

    <hr class="border-t border-gray-300 mb-12">

    <section class="mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-x-0')"
                x-intersect:leave="$el.classList.remove('opacity-100', 'translate-x-0')"
                class="w-full h-full flex justify-center opacity-0 transform translate-x-10 transition duration-1000 ease-out order-1">
                <img src="{{ Storage::url($mission_image) }}" alt="Mission Image"
                    class="rounded-lg w-full object-cover {{ pathinfo(Storage::url($mission_image), PATHINFO_EXTENSION) == 'png' ? 'filter drop-shadow-lg' : 'shadow-lg' }}">
            </div>

            <div x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-x-0')"
                x-intersect:leave="$el.classList.remove('opacity-100', 'translate-x-0')"
                class="opacity-0 transform -translate-x-10 transition duration-1000 ease-out order-2">
                <h2 class="text-3xl sm:text-4xl font-bold text-green-700 mb-4">
                    <i class="fas fa-bullseye mr-2"></i>{{ __('Nuestra Misión') }}
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">{{ $mission }}</p>
            </div>
        </div>
    </section>

    <hr class="border-t border-gray-300 mb-12">

    <section class="mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center lg:flex-row-reverse">
            <div x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-x-0')"
                x-intersect:leave="$el.classList.remove('opacity-100', 'translate-x-0')"
                class="w-full h-full flex justify-center opacity-0 transform -translate-x-10 transition duration-1000 ease-out order-1 lg:order-2">
                <img src="{{ Storage::url($vision_image) }}" alt="Vision Image"
                    class="rounded-lg w-full object-cover {{ pathinfo(Storage::url($vision_image), PATHINFO_EXTENSION) == 'png' ? 'filter drop-shadow-lg' : 'shadow-lg' }}">
            </div>

            <div x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-x-0')"
                x-intersect:leave="$el.classList.remove('opacity-100', 'translate-x-0')"
                class="opacity-0 transform translate-x-10 transition duration-1000 ease-out order-2 lg:order-1">
                <h2 class="text-3xl sm:text-4xl font-bold text-green-700 mb-4">
                    <i class="fas fa-eye mr-2"></i>{{ __('Nuestra Visión') }}
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">{{ $vision }}</p>
            </div>
        </div>
    </section>

    <hr class="border-t border-gray-300 mb-12">

    <section class="mb-12">
        <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 mb-8">
            <i class="fas fa-heart mr-2"></i>{{ __('Nuestros Valores') }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($values as $value)
                <div x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-y-0')"
                    x-intersect:leave="$el.classList.remove('opacity-100', 'translate-y-0')"
                    class="p-4 bg-white shadow-lg rounded-lg text-center opacity-0 transform translate-y-10 transition duration-1000 ease-out">
                    <div class="mb-2">
                        <i class="fas fa-check-circle text-green-500 text-4xl sm:text-5xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">{{ $value }}</h3>
                </div>
            @endforeach
        </div>
    </section>

    <section x-data x-intersect:enter="$el.classList.add('opacity-100', 'translate-y-0')"
        x-intersect:leave="$el.classList.remove('opacity-100', 'translate-y-0')"
        class="bg-gradient-to-r from-green-400 to-green-600 rounded-lg py-8 px-4 text-center shadow-lg opacity-0 transform translate-y-10 transition duration-1000 ease-out">
        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-4">
            <i class="fas fa-users mr-2"></i>{{ __('Únete a Nosotros') }}
        </h3>
        <p class="text-base sm:text-lg text-white mb-6">
            {{ __('Estamos siempre buscando personas talentosas y apasionadas para unirse a nuestro equipo.') }}
        </p>
        <a href="#"
            class="bg-white text-green-700 px-5 py-3 rounded-lg shadow hover:bg-gray-100 transition duration-300 ease-in-out">
            <i class="fas fa-briefcase mr-2"></i>{{ __('Ver Oportunidades') }}
        </a>
    </section>
</div>
