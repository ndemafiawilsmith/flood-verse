<div wire:ignore x-data="mapPicker()" x-init="init()" class="w-full space-y-2">
    <div class="text-sm text-gray-600">
        🗺️ Click anywhere on the map or drag the marker to set location.
    </div>
    <div x-ref="map" style="width:100%;height:400px;border-radius:8px;border:1px solid #ccc;"></div>
</div>

@once
@push('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&v=weekly"
    async defer></script>
@endpush
@endonce

<script>
function mapPicker() {
    return {
        map: null,
        marker: null,
        initialized: false,

        async waitForGoogle() {
            return new Promise((resolve) => {
                const check = () => {
                    if (window.google && google.maps && google.maps.Map) {
                        resolve();
                    } else {
                        setTimeout(check, 250);
                    }
                };
                check();
            });
        },

        async init() {
            await this.waitForGoogle();
            this.initMap();
        },

        initMap() {
            if (this.initialized) return;
            this.initialized = true;

            const defaultLoc = { lat: 6.5244, lng: 3.3792 };

            this.map = new google.maps.Map(this.$refs.map, {
                center: defaultLoc,
                zoom: 12,
                streetViewControl: false,
                fullscreenControl: true,
                mapTypeControl: true,
            });

            // ✅ Add a visible marker
            this.marker = new google.maps.Marker({
                position: defaultLoc,
                map: this.map,
                draggable: true,
                title: "Drag or click to select location",
            });

            // ✅ Click event
            this.map.addListener("click", (e) => {
                const loc = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                this.marker.setPosition(loc);
                this.updateLivewire(loc);
            });

            // ✅ Drag event
            this.marker.addListener("dragend", (e) => {
                const loc = { lat: e.latLng.lat(), lng: e.latLng.lng() };
                this.updateLivewire(loc);
            });

            // ✅ Auto locate user
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((pos) => {
                    const loc = {
                        lat: pos.coords.latitude,
                        lng: pos.coords.longitude,
                    };
                    this.map.setCenter(loc);
                    this.marker.setPosition(loc);
                    this.updateLivewire(loc);
                });
            }
        },

        updateLivewire(loc) {
            const lat = loc.lat.toFixed(6);
            const lng = loc.lng.toFixed(6);
            console.log("📍 Updated:", { lat, lng });

            // ✅ Update Filament's reactive data
            if (this.$wire) {
                try {
                    this.$wire.set('form.data.latitude', lat);
                    this.$wire.set('form.data.longitude', lng);
                } catch (e) {
                    this.updateInputsFallback(lat, lng);
                }
            } else {
                this.updateInputsFallback(lat, lng);
            }
        },

        // ✅ Fallback (ensures visible input updates)
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
