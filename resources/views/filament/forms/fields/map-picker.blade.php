<div
    wire:ignore
    x-data="mapPicker()"
    x-init="init()"
    class="w-full space-y-2"
>
    <div class="text-sm text-gray-600">
        🗺️ Click anywhere on the map or drag the marker to set location.
    </div>
    <div
        x-ref="map"
        style="width:100%;height:400px;border-radius:8px;border:1px solid #ccc;"
    ></div>
</div>

@once
    @push('scripts')
        {{-- ✅ Load Google Maps asynchronously (no callback!) --}}
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&v=weekly&loading=async&libraries=marker"
            async
            defer>
        </script>
    @endpush
@endonce

<script>
    function mapPicker() {
        return {
            map: null,
            marker: null,
            initialized: false,

            async waitForGoogle() {
                // Wait until Google Maps is fully ready
                return new Promise((resolve) => {
                    const check = () => {
                        if (window.google && google.maps && google.maps.Map && google.maps.marker) {
                            resolve();
                        } else {
                            setTimeout(check, 250);
                        }
                    };
                    check();
                });
            },

            async init() {
                // Filament/Livewire sometimes delay DOM — small wait ensures hydration
                setTimeout(async () => {
                    await this.waitForGoogle();
                    this.initMap();
                }, 500);
            },

            initMap() {
                if (this.initialized) return;
                this.initialized = true;

                const defaultLoc = { lat: 6.5244, lng: 3.3792 }; // Lagos fallback

                // Create map
                this.map = new google.maps.Map(this.$refs.map, {
                    center: defaultLoc,
                    zoom: 12,
                    mapId: 'FilamentVictimPicker', // optional custom ID
                    streetViewControl: false,
                    fullscreenControl: true,
                    mapTypeControl: true,
                });

                // ✅ Use new AdvancedMarkerElement (no warnings)
                const { AdvancedMarkerElement } = google.maps.marker;
                this.marker = new AdvancedMarkerElement({
                    position: defaultLoc,
                    map: this.map,
                    gmpDraggable: true,
                    title: "Drag or click to select location",
                });

                // Click event
                this.map.addListener("click", (e) => {
                    const loc = {
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                    };
                    this.marker.position = loc;
                    this.updateLivewire(loc);
                });

                // Drag end event
                this.marker.addListener("dragend", (e) => {
                    const loc = {
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng(),
                    };
                    this.updateLivewire(loc);
                });

                // Auto-locate if allowed
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((pos) => {
                        const loc = {
                            lat: pos.coords.latitude,
                            lng: pos.coords.longitude,
                        };
                        this.map.setCenter(loc);
                        this.map.setZoom(13);
                        this.marker.position = loc;
                        this.updateLivewire(loc);
                    });
                }
            },

            updateLivewire(loc) {
                const lat = loc.lat.toFixed(6);
                const lng = loc.lng.toFixed(6);
                console.log("📍 Updated:", { lat, lng });

                // ✅ Update Filament reactive data
                if (this.$wire) {
                    try {
                        this.$wire.set('data.latitude', lat);
                        this.$wire.set('data.longitude', lng);
                    } catch (e) {
                        this.updateInputsFallback(lat, lng);
                    }
                } else {
                    this.updateInputsFallback(lat, lng);
                }
            },

            updateInputsFallback(lat, lng) {
                ['latitude', 'longitude'].forEach((name, i) => {
                    const input = document.querySelector(`input[name="${name}"]`);
                    if (input) {
                        input.value = i === 0 ? lat : lng;
                        ['input', 'change', 'blur'].forEach(ev =>
                            input.dispatchEvent(new Event(ev, { bubbles: true }))
                        );
                    }
                });
            },
        };
    }
</script>
