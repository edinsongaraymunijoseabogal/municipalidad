<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? app('configService')->get('site_title') }}</title>
    {{-- Meta --}}
    <meta name="description" content="{{ $description ?? app('configService')->get('description') }}" />
    <link rel="canonical" href="{{ Request::url() }}" />
    <meta name="og:title" content="{{ $title ?? app('configService')->get('site_title') }}" />
    <meta name="og:description" content="{{ $description ?? app('configService')->get('description') }}" />
    <meta name="og:url" content="{{ Request::url() }}" />
    <meta name="og:locale" content="es_LA" />
    <meta name="og:type" content="website" />
    <meta name="og:image" content="" />
    <meta property="og:image:width" content="552" />
    <meta property="og:image:height" content="310" />
    <meta itemProp="image" content="" />
    <link rel="icon"
        href="{{ app('configService')->get('site_favicon') ? Storage::url(app('configService')->get('site_favicon')) : '/favicon.ico' }}" />
    <meta name="theme-color" content="#000000" />
    <meta name="robots" content="index, follow" />
    {{-- End Meta --}}
    {{-- Styles --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    @stack('styles')
    {{-- End Styles --}}
</head>

<body class="bg-gray-100">
    <!-- Redes sociales arriba -->
    <div class="bg-green-700 p-2 shadow-md fixed top-0 left-0 w-full z-50">
        <div class="container mx-auto flex justify-end space-x-4">
            <a href="#" class="text-white hover:text-green-300 transition-colors duration-300"><i
                    class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white hover:text-green-300 transition-colors duration-300"><i
                    class="fab fa-twitter"></i></a>
            <a href="#" class="text-white hover:text-green-300 transition-colors duration-300"><i
                    class="fab fa-instagram"></i></a>
        </div>
    </div>

    <!-- Navbar principal -->
    <nav id="navbar"
        class="bg-green-600 p-4 shadow-md fixed top-10 left-0 w-full z-50 transition duration-500 ease-in-out">

        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo and Site Title -->
            <a href="{{ route('web.home') }}" class="text-white text-lg font-bold flex items-center space-x-2">
                <img src="{{ Storage::url(app('configService')->get('site_logo')) }}" alt="Logo"
                    class="w-10 h-10 rounded-full">
                <span class="hidden md:inline-block">{{ app('configService')->get('site_title') }}</span>
            </a>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white focus:outline-none" aria-label="Menu" id="mobile-menu-button">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                <ul class="flex space-x-6 text-sm font-semibold">
                    <li>
                        <a href="{{ route('web.home') }}"
                            class="text-gray-200 hover:text-white transition-colors duration-300 {{ request()->is('/') ? 'text-white border-b-2 border-white' : '' }}">
                            {{ __('Home') }}
                        </a>
                    </li>

                    <!-- Dropdown Menu -->
                    <li class="relative">
                        <button id="institutionalMenuButton"
                            class="text-gray-200 hover:text-white flex items-center transition-colors duration-300">
                            {{ __('Institutional') }} <i class="fas fa-caret-down ml-1"></i>
                        </button>
                        <div id="institutionalDropdown"
                            class="absolute hidden bg-white rounded-lg shadow-lg py-2 mt-2 w-44 z-50">
                            <!-- Contenido del menú desplegable -->
                            <a href="{{ route('web.aboutUs') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-green-600 hover:text-white">
                                {{ __('Information') }}
                            </a>
                            <a href="{{ Storage::url(app('configService')->get('organigram_pdf')) }}" target="_blank"
                                class="block px-4 py-2 text-gray-700 hover:bg-green-600 hover:text-white">
                                {{ __('Organigram') }}
                            </a>
                            <a href="{{ route('web.directory') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-green-600 hover:text-white">
                                {{ __('Directory') }}
                            </a>
                        </div>
                    </li>

                    <li><a href="{{ Route('web.documents') }}"
                            class="text-gray-200 hover:text-white transition-colors duration-300 {{ request()->is('documentos*') ? 'text-white border-b-2 border-white' : '' }}">
                            {{ __('Transparency') }}</a></li>
                    <li><a href="{{ route('web.posts') }}"
                            class="text-gray-200 hover:text-white transition-colors duration-300 {{ request()->is('noticias*') ? 'text-white border-b-2 border-white' : '' }}">
                            {{ __('News') }}</a></li>
                    <li><a href="{{ route('web.videos') }}"
                            class="text-gray-200 hover:text-white transition-colors duration-300 {{ request()->is('videos*') ? 'text-white border-b-2 border-white' : '' }}">
                            {{ __('Videos') }}</a></li>
                </ul>
            </div>

            <!-- Login Button -->
            <div class="hidden md:flex">
                <a href="{{ route('admin.index') }}"
                    class="bg-white text-green-600 hover:bg-green-700 hover:text-white transition-colors duration-300 rounded-full px-4 py-2 shadow-md flex items-center space-x-2">
                    <i class="fas fa-user"></i> <span>{{ __('Login') }}</span>
                </a>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden mt-4 md:hidden" id="mobile-menu">
            <ul class="space-y-4 bg-green-600 text-white py-4 px-4 rounded-lg shadow-lg text-center">
                <li><a href="{{ route('web.home') }}"
                        class="block hover:text-green-200 transition-colors duration-300 {{ request()->is('/') ? 'text-green-200' : '' }}">{{ __('Home') }}</a>
                </li>
                <li class="relative">
                    <!-- Dropdown Menu for Mobile -->
                    <button id="dropdownMobileLink" data-dropdown-toggle="dropdownMobile"
                        class="w-full text-left hover:text-green-200 transition-colors duration-300 flex items-center justify-center">
                        {{ __('Institutional') }} <i class="fas fa-caret-down ml-1"></i>
                    </button>
                    <div id="dropdownMobile" class="hidden bg-white text-gray-700 rounded-lg shadow-lg mt-2">
                        <ul class="py-2 space-y-1">
                            <li><a href="{{ route('web.aboutUs') }}"
                                    class="block px-4 py-2 hover:bg-green-600 hover:text-white transition-colors duration-300">{{ __('Information') }}</a>
                            </li>
                            <li><a href="{{ Storage::url(app('configService')->get('organigram_pdf')) }}"
                                    class="block px-4 py-2 hover:bg-green-600 hover:text-white transition-colors duration-300">{{ __('Organigram') }}</a>
                            </li>
                            <li><a href="{{ route('web.directory') }}"
                                    class="block px-4 py-2 hover:bg-green-600 hover:text-white transition-colors duration-300">{{ __('Directory') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a href="{{ Route('web.documents') }}"
                        class="block hover:text-green-200 transition-colors duration-300">{{ __('Transparency') }}</a>
                </li>
                <li><a href="{{ route('admin.index') }}"
                        class="block bg-green-700 text-white px-4 py-2 rounded-full shadow-md hover:bg-green-800 transition-colors duration-300">
                        <i class="fas fa-user"></i> {{ __('Login') }}</a></li>
                <li><a href="{{ route('web.posts') }}"
                        class="block hover:text-green-200 transition-colors duration-300">{{ __('News') }}</a></li>
                <li><a href="{{ route('web.videos') }}"
                        class="block hover:text-green-200 transition-colors duration-300">{{ __('Videos') }}</a></li>
            </ul>
        </div>
    </nav>


    <!-- Main content -->
    <div class="container mx-auto mt-24 py-8">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-700 to-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- About Us Section -->
            <div>
                <h3 class="text-2xl font-bold mb-4 border-b-2 border-white pb-2">{{ __('About Us') }}</h3>
                <p class="text-gray-300 text-sm leading-relaxed">
                    {{ app('configService')->get('about_us_text') }}
                </p>
            </div>

            <!-- Quick Links Section -->
            <div>
                <h3 class="text-2xl font-bold mb-4 border-b-2 border-white pb-2">{{ __('Quick Links') }}</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="#"
                            class="text-gray-300 hover:text-white transition-all duration-300">{{ __('Home') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-300 hover:text-white transition-all duration-300">{{ __('About Us') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-300 hover:text-white transition-all duration-300">{{ __('Services') }}</a>
                    </li>
                    <li>
                        <a href="#"
                            class="text-gray-300 hover:text-white transition-all duration-300">{{ __('Contact') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div>
                <h3 class="text-2xl font-bold mb-4 border-b-2 border-white pb-2">{{ __('Contact Us') }}</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone-alt text-gray-400"></i>
                        <span class="text-gray-300">{{ app('configService')->get('contact_phone') }}</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-gray-400"></i>
                        <a href="mailto:{{ app('configService')->get('contact_email') }}"
                            class="text-gray-300 hover:text-white transition-all duration-300">
                            {{ app('configService')->get('contact_email') }}
                        </a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        <span class="text-gray-300">{{ app('configService')->get('contact_address') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom Section -->
        <div class="border-t border-gray-600 mt-12 pt-6">
            <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
                <p class="text-gray-400 text-sm text-center md:text-left mb-4 md:mb-0">© {{ date('Y') }}
                    {{ app('configService')->get('site_title') }} - {{ __('All rights reserved.') }}</p>
                <div class="flex space-x-6">
                    <a href="#"
                        class="text-gray-300 hover:text-white transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="#"
                        class="text-gray-300 hover:text-white transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#"
                        class="text-gray-300 hover:text-white transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="#"
                        class="text-gray-300 hover:text-white transition-all duration-300 transform hover:scale-110">
                        <i class="fab fa-linkedin-in text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>


    <!-- Livewire Scripts -->
    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    @stack('scripts')


    <script>
        const institutionalMenuButton = document.getElementById('institutionalMenuButton');
        const institutionalDropdown = document.getElementById('institutionalDropdown');

        institutionalMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            institutionalDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            const isClickInside = institutionalMenuButton.contains(event.target) || institutionalDropdown.contains(
                event.target);

            if (!isClickInside) {
                institutionalDropdown.classList.add('hidden');
            }
        });
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

</body>

</html>
