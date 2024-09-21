<div class="relative w-full h-96 bg-gray-100">
    <div class="bg-white border border-gray-300 rounded-lg h-full overflow-hidden relative shadow-lg">
        <!-- Mapa -->
        <div id="map" class="w-full h-full z-0"></div>

        <!-- Caja de información flotante -->
        <div
            class="absolute bottom-6 left-6 bg-white p-5 rounded-lg shadow-lg border border-gray-300 max-w-sm transition duration-500 ease-in-out transform hover:scale-105 hover:shadow-2xl">
            <h3 class="text-xl font-bold text-green-700 mb-2">{{ app('configService')->get('site_title') }}</h3>
            <p class="text-gray-700">{{ app('configService')->get('contact_address') }}</p>
        </div>
    </div>

    <!-- Script de Google Maps -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD15P64QMmZACOMg7sqBnzpjtZsbTu4_0c&libraries=places&v=weekly"
        defer></script>

    <script>
        function initMap() {
            const mapOptions = {
                center: {
                    lat: {{ app('configService')->get('latitude') }},
                    lng: {{ app('configService')->get('longitude') }}
                },
                zoom: 16,
                draggable: false,
            };

            // Inicializamos el mapa
            const map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Creamos el marcador
            const marker = new google.maps.Marker({
                position: {
                    lat: {{ app('configService')->get('latitude') }},
                    lng: {{ app('configService')->get('longitude') }}
                },
                map: map,
                title: "{{ app('configService')->get('site_title') }}"
            });

            // Creamos el InfoWindow para mostrar la dirección
            const infoWindow = new google.maps.InfoWindow({
                content: `<div>
                            <h3 style="font-size:16px;font-weight:bold;">{{ app('configService')->get('site_title') }}</h3>
                            <p style="font-size:14px;color:#333;">{{ app('configService')->get('contact_address') }}</p>
                          </div>`
            });

            // Mostrar InfoWindow cuando el marcador es clicado
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });

            // Abrimos el InfoWindow automáticamente al cargar el mapa
            infoWindow.open(map, marker);
        }

        // Iniciar el mapa cuando el DOM esté cargado
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
</div>
