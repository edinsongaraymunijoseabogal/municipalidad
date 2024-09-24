<div class="app-content pt-3 p-md-3 p-lg-4">
    <div class="container-xl">
        <h1 class="app-page-title">{{ __('Settings') }}</h1>

        <nav class="app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
            <a class="flex-sm-fill text-sm-center nav-link @if ($activeTab == 'general-settings') active @endif"
                wire:click="setActiveTab('general-settings')" data-bs-toggle="tab" href="#general-settings" role="tab">
                {{ __('General') }}
            </a>
            <a class="flex-sm-fill text-sm-center nav-link @if ($activeTab == 'about-us-settings') active @endif"
                wire:click="setActiveTab('about-us-settings')" data-bs-toggle="tab" href="#about-us-settings"
                role="tab">
                {{ __('About Us') }}
            </a>
            <a class="flex-sm-fill text-sm-center nav-link @if ($activeTab == 'social-media-settings') active @endif"
                wire:click="setActiveTab('social-media-settings')" data-bs-toggle="tab" href="#social-media-settings"
                role="tab">
                {{ __('Social Media') }}
            </a>
            <a class="flex-sm-fill text-sm-center nav-link @if ($activeTab == 'contact-settings') active @endif"
                wire:click="setActiveTab('contact-settings')" data-bs-toggle="tab" href="#contact-settings"
                role="tab">
                {{ __('Contact') }}
            </a>
        </nav>

        <div class="tab-content" id="settings-tab-content">
            <div class="tab-pane fade @if ($activeTab == 'general-settings') show active @endif" id="general-settings"
                role="tabpanel">
                @if (session()->has('generalMessage'))
                    <div class="alert alert-success">
                        {{ session('generalMessage') }}
                    </div>
                @endif
                <div class="app-card app-card-settings shadow-sm p-4">
                    <div class="app-card-body">
                        <form wire:submit.prevent="saveGeneralSettings">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="site_logo" class="form-label">{{ __('Site Logo') }}</label>
                                    <div class="dropzone"
                                        style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;"
                                        onclick="document.getElementById('logoImage').click();">
                                        @if ($site_logo && !is_string($site_logo))
                                            <img src="{{ $site_logo->temporaryUrl() }}" alt="{{ __('Site Logo') }}"
                                                style="max-height: 150px;">
                                        @elseif($existing_site_logo)
                                            <img src="{{ Storage::url($existing_site_logo) }}"
                                                alt="{{ __('Site Logo') }}" class="img-fluid rounded"
                                                style="max-height: 150px;">
                                        @else
                                            <p>{{ __('Drag & Drop an image, click to upload') }}</p>
                                        @endif
                                        <input type="file" id="logoImage" wire:model="site_logo"
                                            style="display: none;" accept="image/*" />
                                    </div>
                                    @error('site_logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label for="site_favicon" class="form-label">{{ __('Site Logo') }}</label>
                                    <div class="dropzone"
                                        style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;"
                                        onclick="document.getElementById('faviconImage').click();">
                                        @if ($site_favicon && !is_string($site_favicon))
                                            <img src="{{ $site_favicon->temporaryUrl() }}"
                                                alt="{{ __('Site Favicon') }}" style="max-height: 150px;">
                                        @elseif($existing_site_favicon)
                                            <img src="{{ Storage::url($existing_site_favicon) }}"
                                                alt="{{ __('Site Favicon') }}" class="img-fluid rounded"
                                                style="max-height: 150px;">
                                        @else
                                            <p>{{ __('Drag & Drop an image, click to upload') }}</p>
                                        @endif
                                        <input type="file" id="faviconImage" wire:model="site_favicon"
                                            style="display: none;" accept="image/*" />
                                    </div>
                                    @error('site_favicon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-12 col-md-4">
                                    <label for="site_title" class="form-label">{{ __('Site Name') }}</label>
                                    <input type="text" wire:model="site_title" class="form-control">
                                    @error('site_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-8">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea wire:model="description" class="form-control" rows="4"></textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-12 col-md-6">
                                    <label for="keywords" class="form-label">{{ __('Keywords') }}</label>
                                    <input type="text" wire:model="keywords" class="form-control">
                                    @error('keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="meta_description"
                                        class="form-label">{{ __('Meta Description') }}</label>
                                    <textarea wire:model="meta_description" class="form-control" rows="3"></textarea>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade @if ($activeTab == 'about-us-settings') show active @endif" id="about-us-settings"
                role="tabpanel">
                <div class="g-4">

                    @if (session()->has('aboutUsMessage'))
                        <div class="alert alert-success">
                            {{ session('aboutUsMessage') }}
                        </div>
                    @endif

                    <div class="mb-2">
                        <h3 class="section-title">{{ __('About Us') }}</h3>
                    </div>
                    <div class="mt-4">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                                <form wire:submit.prevent="saveAboutUsSettings">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="about_us_text"
                                                    class="form-label">{{ __('About Us Text') }}</label>
                                                <textarea wire:model="about_us_text" class="form-control" rows="6"></textarea>
                                                @error('about_us_text')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="about_us_image"
                                                    class="form-label">{{ __('About Us Image') }}</label>
                                                <div class="dropzone"
                                                    style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;"
                                                    onclick="document.getElementById('aboutUsImage').click();">
                                                    @if ($about_us_image && !is_string($about_us_image))
                                                        <img src="{{ $about_us_image->temporaryUrl() }}"
                                                            alt="{{ __('About Us Image') }}"
                                                            style="max-height: 150px;">
                                                    @elseif($existing_about_us_image)
                                                        <img src="{{ Storage::url($existing_about_us_image) }}"
                                                            alt="{{ __('About Us Image') }}"
                                                            class="img-fluid rounded" style="max-height: 150px;">
                                                    @else
                                                        <p>{{ __('Drag & Drop an image, click to upload') }}</p>
                                                    @endif
                                                    <input type="file" id="aboutUsImage"
                                                        wire:model="about_us_image" style="display: none;"
                                                        accept="image/*" />
                                                </div>
                                                @error('about_us_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label for="mission" class="form-label">{{ __('Mission') }}</label>
                                            <textarea wire:model="mission" class="form-control" rows="4"></textarea>
                                            @error('mission')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div class="mt-3">
                                                <label for="mission_image"
                                                    class="form-label">{{ __('Mission Image') }}</label>
                                                <input type="file" wire:model="mission_image" accept="image/*"
                                                    class="form-control">
                                                @error('mission_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <div class="mt-2">
                                                    <label for="mission_image"
                                                        class="form-label">{{ __('Mission Image') }}</label>
                                                    <div class="dropzone"
                                                        style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;"
                                                        onclick="document.getElementById('missionImage').click();">
                                                        @if ($mission_image && !is_string($mission_image))
                                                            <img src="{{ $mission_image->temporaryUrl() }}"
                                                                alt="{{ __('Mission Image') }}"
                                                                style="max-height: 150px;">
                                                        @elseif($existing_mission_image)
                                                            <img src="{{ Storage::url($existing_mission_image) }}"
                                                                alt="{{ __('Mission Image') }}"
                                                                class="img-fluid rounded" style="max-height: 150px;">
                                                        @else
                                                            <p>{{ __('Drag & Drop an image, click to upload') }}</p>
                                                        @endif
                                                        <input type="file" id="missionImage"
                                                            wire:model="mission_image" style="display: none;"
                                                            accept="image/*" />
                                                    </div>
                                                    @error('mission_image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5 mb-3">
                                            <label for="vision" class="form-label">{{ __('Vision') }}</label>
                                            <textarea wire:model="vision" class="form-control" rows="4"></textarea>
                                            @error('vision')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                            <div class="mt-3">
                                                <label for="vision_image"
                                                    class="form-label">{{ __('Vision Image') }}</label>
                                                <input type="file" wire:model="vision_image" accept="image/*"
                                                    class="form-control">
                                                @error('vision_image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                <div class="mt-2">
                                                    <label for="vision_image"
                                                        class="form-label">{{ __('Vision Image') }}</label>
                                                    <div class="dropzone"
                                                        style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;"
                                                        onclick="document.getElementById('vision_image').click();">
                                                        @if ($vision_image && !is_string($vision_image))
                                                            <img src="{{ $vision_image->temporaryUrl() }}"
                                                                alt="{{ __('Vision Image') }}"
                                                                style="max-height: 150px;">
                                                        @elseif($existing_vision_image)
                                                            <img src="{{ Storage::url($existing_vision_image) }}"
                                                                alt="{{ __('Vision Image') }}"
                                                                class="img-fluid rounded" style="max-height: 150px;">
                                                        @else
                                                            <p>{{ __('Drag & Drop an image, click to upload') }}</p>
                                                        @endif
                                                        <input type="file" id="vision_image"
                                                            wire:model="vision_image" style="display: none;"
                                                            accept="image/*" />
                                                    </div>
                                                    @error('vision_image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <label for="values" class="form-label">{{ __('Values') }}</label>
                                            <div id="values-list">
                                                @foreach ($values as $index => $value)
                                                    <div class="input-group mb-2">
                                                        <input type="text" wire:model="values.{{ $index }}"
                                                            class="form-control"
                                                            placeholder="{{ __('Insert value') }}">
                                                        <button type="button text-small" class="btn btn-danger"
                                                            wire:click.prevent="removeValue({{ $index }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-success"
                                                wire:click.prevent="addValue">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="mb-3 row">
                                        <div class="col-12 col-md-7">
                                            <label for="organigram"
                                                class="form-label">{{ __('Organigram (PDF)') }}</label>
                                            <input type="file" wire:model="organigram_pdf"
                                                accept="application/pdf" class="form-control" />
                                            @error('organigram_pdf')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-5">
                                            @if ($existing_organigram_pdf)
                                                <div class="mt-3">
                                                    <label>{{ __('Current Organigram PDF:') }}</label>
                                                    <embed src="{{ Storage::url($existing_organigram_pdf) }}"
                                                        type="application/pdf" width="100%" height="300px" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade @if ($activeTab == 'social-media-settings') show active @endif"
                id="social-media-settings" role="tabpanel">
                <div class="g-4">

                    @if (session()->has('socialMediaMessage'))
                        <div class="alert alert-success">
                            {{ session('socialMediaMessage') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <h3 class="section-title">{{ __('Social Media') }}</h3>
                    </div>
                    <div class="mt-4">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <div class="app-card-body">
                                <form wire:submit.prevent="saveSocialMediaSettings">
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-4">
                                            <label for="facebook" class="form-label">{{ __('Facebook') }}</label>
                                            <input type="text" wire:model="facebook" class="form-control"
                                                placeholder="{{ __('Insert username') }}">
                                            @error('facebook')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label for="twitter" class="form-label">{{ __('Twitter') }}</label>
                                            <input type="text" wire:model="twitter" class="form-control"
                                                placeholder="{{ __('Insert username') }}">
                                            @error('twitter')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label for="instagram" class="form-label">{{ __('Instagram') }}</label>
                                            <input type="text" wire:model="instagram" class="form-control"
                                                placeholder="{{ __('Insert username') }}">
                                            @error('instagram')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade @if ($activeTab == 'contact-settings') show active @endif" id="contact-settings"
                role="tabpanel">
                <div class="g-4">

                    @if (session()->has('contactMessage'))
                        <div class="alert alert-success">
                            {{ session('contactMessage') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <h3 class="section-title">{{ __('Contact Information') }}</h3>
                    </div>
                    <div class="app-card app-card-settings shadow-sm p-4">
                        <div class="app-card-body">
                            <form wire:submit.prevent="saveContactSettings">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="contact_phone"
                                            class="form-label">{{ __('Contact Phone') }}</label>
                                        <input type="text" wire:model="contact_phone" class="form-control">
                                        @error('contact_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="contact_email"
                                            class="form-label">{{ __('Contact Email') }}</label>
                                        <input type="email" wire:model="contact_email" class="form-control">
                                        @error('contact_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div>
                                    <div class="mb-3">
                                        <label for="autocomplete"
                                            class="form-label">{{ __('Enter Address') }}</label>
                                        <input class="form-control" id="ship-address" wire:model="contact_address"
                                            required autocomplete="off" />
                                        @error('contact_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Mapa interactivo -->
                                    <div class="mb-3">
                                        <label for="map"
                                            class="form-label">{{ __('Select Location on Map') }}</label>
                                        <div wire:ignore>
                                            <div id="map" class="w-100" style="height: 400px;"></div>
                                        </div>
                                    </div>

                                    <!-- Campos ocultos para las coordenadas -->
                                    <input type="hidden" wire:model="latitude">
                                    <input type="hidden" wire:model="longitude">
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @push('css')
            @endpush

            @push('js')
                <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD15P64QMmZACOMg7sqBnzpjtZsbTu4_0c&libraries=places&v=weekly"
                    defer></script>

                <script>
                    let map, marker, autocomplete, geocoder;

                    async function initMap() {
                        const position = {
                            lat: {{ $latitude ?? -25.344 }},
                            lng: {{ $longitude ?? 131.031 }}
                        };

                        const {
                            Map
                        } = await google.maps.importLibrary("maps");

                        map = new Map(document.getElementById("map"), {
                            zoom: 15,
                            center: position,
                        });

                        geocoder = new google.maps.Geocoder();

                        marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            draggable: true,
                            title: "Drag me!",
                        });

                        google.maps.event.addListener(marker, 'dragend', function(event) {
                            const newLat = event.latLng.lat();
                            const newLng = event.latLng.lng();

                            @this.set('latitude', newLat);
                            @this.set('longitude', newLng);

                            geocodeLatLng(newLat, newLng);
                        });

                        map.addListener("click", (event) => {
                            const clickLat = event.latLng.lat();
                            const clickLng = event.latLng.lng();

                            marker.setPosition({
                                lat: clickLat,
                                lng: clickLng
                            });

                            @this.set('latitude', clickLat);
                            @this.set('longitude', clickLng);

                            geocodeLatLng(clickLat, clickLng);
                        });

                        initAutocomplete();
                    }

                    function initAutocomplete() {
                        const addressField = document.querySelector("#ship-address");

                        autocomplete = new google.maps.places.Autocomplete(addressField, {
                            componentRestrictions: {
                                country: ["pe"]
                            },
                            fields: ["address_components", "geometry"],
                            types: ["address"],
                        });

                        autocomplete.addListener("place_changed", onPlaceChanged);
                    }

                    function onPlaceChanged() {
                        const place = autocomplete.getPlace();

                        if (place.geometry) {
                            const latitude = place.geometry.location.lat();
                            const longitude = place.geometry.location.lng();

                            @this.set('latitude', latitude);
                            @this.set('longitude', longitude);

                            map.setCenter({
                                lat: latitude,
                                lng: longitude
                            });

                            marker.setPosition({
                                lat: latitude,
                                lng: longitude
                            });
                        }
                    }

                    function geocodeLatLng(lat, lng) {
                        const latlng = {
                            lat: parseFloat(lat),
                            lng: parseFloat(lng)
                        };
                        geocoder.geocode({
                            location: latlng
                        }, (results, status) => {
                            if (status === "OK") {
                                if (results[0]) {
                                    document.querySelector("#ship-address").value = results[0].formatted_address;
                                    @this.set('contact_address', results[0].formatted_address);
                                } else {
                                    console.log("No results found");
                                }
                            } else {
                                console.log("Geocoder failed due to: " + status);
                            }
                        });
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        initMap();
                    });
                </script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        window.addEventListener('livewire:load', () => {
                            const activeTab = localStorage.getItem('activeTab');
                            if (activeTab) {
                                const componentId = window.Livewire.components.componentsByName.SettingsCrud[0].id;
                                window.Livewire.find(componentId).set('activeTab', activeTab);
                            }
                        });
                    });

                    document.addEventListener('saved', event => {
                        localStorage.setItem('activeTab', event.detail.tab);
                    });
                </script>
            @endpush
        </div>
    </div>
</div>
