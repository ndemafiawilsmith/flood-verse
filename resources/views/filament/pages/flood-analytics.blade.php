{{-- 📍 Flood Victims & Safe Zones Map --}}
<x-filament::card>
    <h2 class="text-lg font-bold mb-2">Victims & Safe Zones</h2>

    <div
        wire:ignore
        x-data="floodMap({
            victims: {{ json_encode($victims) }},
            safeZones: {{ json_encode($safeZones) }}
        })"
        x-init="init()"
        style="width:100%;height:500px;border-radius:8px;border:1px solid #ddd;"
    >
        <div x-ref="map" style="width:100%;height:100%;"></div>
    </div>
</x-filament::card>

@push('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&v=weekly&loading=async&libraries=drawing"
    async defer>
</script>

<script>
function floodMap({ victims, safeZones }) {
    return {
        map: null,
        markers: [],
        safeZoneMarkers: [],

        async waitForGoogle() {
            return new Promise(resolve => {
                const check = () => {
                    if (window.google && google.maps && google.maps.Map) resolve();
                    else setTimeout(check, 200);
                };
                check();
            });
        },

        async init() {
            await this.waitForGoogle();

            const defaultCenter = { lat: 6.5, lng: 6.7 }; // Ogbaru
            this.map = new google.maps.Map(this.$refs.map, {
                center: defaultCenter,
                zoom: 9,
                mapId: 'FloodAnalyticsMap',
                streetViewControl: false,
                fullscreenControl: true,
                mapTypeControl: true,
            });

            this.loadVictimMarkers(victims);
            this.loadSafeZoneMarkers(safeZones);
            this.loadDrawingTools();
        },

        // 🔴 Victims
        loadVictimMarkers(victims) {
            victims.forEach(v => {
                if (!v.latitude || !v.longitude) return;

                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(v.latitude), lng: parseFloat(v.longitude) },
                    map: this.map,
                    title: v.name || 'Unknown Victim',
                    icon: { url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png" },
                });

                const info = new google.maps.InfoWindow({
                    content: `<div><strong>${v.name}</strong><br>${v.location || 'Unknown area'}</div>`,
                });

                marker.addListener('click', () => info.open(this.map, marker));
                this.markers.push(marker);
            });
        },

        // 🟢 Safe Zones
        loadSafeZoneMarkers(safeZones) {
            safeZones.forEach(zone => {
                if (!zone.latitude || !zone.longitude) return;

                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(zone.latitude), lng: parseFloat(zone.longitude) },
                    map: this.map,
                    title: zone.name || 'Safe Zone',
                    icon: { url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png" },
                });

                const info = new google.maps.InfoWindow({
                    content: `
                        <div style="font-size:14px;">
                            🏠 <strong>${zone.name}</strong><br>
                            ${zone.address || 'No address'}<br>
                            Capacity: ${zone.capacity ?? 'N/A'}
                        </div>`,
                });

                marker.addListener('click', () => info.open(this.map, marker));
                this.safeZoneMarkers.push(marker);
            });
        },

        // 🧭 Drawing + selection
        loadDrawingTools() {
            const drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: null,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.RECTANGLE,
                        google.maps.drawing.OverlayType.CIRCLE,
                        google.maps.drawing.OverlayType.POLYGON,
                    ],
                },
            });

            drawingManager.setMap(this.map);

            google.maps.event.addListener(drawingManager, 'overlaycomplete', (event) => {
                let shapeData = null;

                if (event.type === 'circle') {
                    const center = event.overlay.getCenter();
                    shapeData = {
                        type: 'circle',
                        center: { lat: center.lat(), lng: center.lng() },
                        radius: event.overlay.getRadius(),
                    };
                } else if (event.type === 'rectangle') {
                    const bounds = event.overlay.getBounds();
                    shapeData = {
                        type: 'rectangle',
                        bounds: {
                            north: bounds.getNorthEast().lat(),
                            east: bounds.getNorthEast().lng(),
                            south: bounds.getSouthWest().lat(),
                            west: bounds.getSouthWest().lng(),
                        },
                    };
                } else if (event.type === 'polygon') {
                    const path = event.overlay.getPath().getArray().map(p => ({
                        lat: p.lat(),
                        lng: p.lng(),
                    }));
                    shapeData = { type: 'polygon', path };
                }

                console.log('🟦 Drawn shape:', shapeData);

                // 🚀 Send one unified request for both victims + safe zones
                fetch('/admin/flood/selection', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify(shapeData),
                })
                .then(res => res.json())
                .then(data => {
                    console.log('✅ Selection:', data);
                    alert(`${data.victims.length} victims and ${data.safe_zones.length} safe zones found.`);
                });
            });
        },
    };
}
</script>
@endpush
