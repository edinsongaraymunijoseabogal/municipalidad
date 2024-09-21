<div class="container mx-auto px-4 md:px-6 lg:px-8">
    <!-- Formulario y mapa arriba -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Columna izquierda: Formulario de contacto -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-green-600">{{ __('Contact us') }}</h2>
            <p class="text-gray-600 mb-6">{{ __('Reach out to us for any inquiry') }}</p>

            <!-- Formulario de contacto -->
            <form>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Full name') }}</label>
                    <input type="text" wire:model="name" id="name"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="{{ __('Full name') }}">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Your email') }}</label>
                    <input type="email" wire:model="email" id="email"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                        placeholder="{{ __('Your email') }}">
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700">{{ __('Message') }}</label>
                    <textarea wire:model="message" id="message"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                        rows="4" placeholder="{{ __('Message') }}"></textarea>
                    @error('message')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    {{ __('Submit') }}
                </button>
            </form>
        </div>

        <!-- Columna derecha: Google Map -->
        <div class="flex flex-col items-center bg-white border rounded">
            <!-- Mapa de Google -->
            <div id="map" class="w-full h-full"></div>
        </div>
    </div>

    <!-- Sección inferior con íconos e información de contacto -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Localización -->
        <div class="flex flex-col items-center">
            <div class="text-green-600 text-4xl mb-2">
                <i class="fas fa-map-marker-alt"></i> <!-- Icono de localización -->
            </div>
            <h3 class="text-xl font-semibold text-green-600">{{ __('Location') }}</h3>
            <p class="text-gray-600">{{ $contact_address }}</p>
        </div>

        <!-- Email -->
        <div class="flex flex-col items-center">
            <div class="text-green-600 text-4xl mb-2">
                <i class="fas fa-envelope"></i> <!-- Icono de email -->
            </div>
            <h3 class="text-xl font-semibold text-green-600">{{ __('Email') }}</h3>
            <p class="text-gray-600">{{ $contact_email }}</p>
        </div>

        <!-- Teléfono -->
        <div class="flex flex-col items-center">
            <div class="text-green-600 text-4xl mb-2">
                <i class="fas fa-phone-alt"></i> <!-- Icono de teléfono -->
            </div>
            <h3 class="text-xl font-semibold text-green-600">{{ __('Phone') }}</h3>
            <p class="text-gray-600">{{ $contact_phone }}</p>
        </div>
    </div>
</div>

@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD15P64QMmZACOMg7sqBnzpjtZsbTu4_0c&libraries=places&v=weekly"
        defer></script>

    <script>
        function initMap() {
            const mapOptions = {
                center: {
                    lat: {{ $latitude }},
                    lng: {{ $longitude }}
                },
                zoom: 16,
                disableDefaultUI: true,
                draggable: false, // No permite mover el mapa
            };

            const map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Añadir marcador
            const marker = new google.maps.Marker({
                position: {
                    lat: {{ $latitude }},
                    lng: {{ $longitude }}
                },
                map: map,
                title: "{{ $site_title }}"
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
@endpush
