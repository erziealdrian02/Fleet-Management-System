<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <a href="{{ route('trips') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Gps Trackings</a>
                <span>›</span>
                <span>Detail</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Trip Detail :</h1>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-8">{{ $tripsList->no_sppd }}</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <!-- Trip Details -->
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Driver</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->driver->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Vehicle</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->vehicle->license_plate }} - {{ $tripsList->vehicle->type }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Start Location</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->start_location }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">End Location</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->end_location }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Start Time</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->start_time }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">End Time</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->end_time }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Distance</h3>
                        <p class="mt-1 text-lg text-gray-900 dark:text-white">{{ $tripsList->distance }} km</p>
                    </div>
                </div>

                <!-- Current Time Display -->
                <div class="mb-4 text-center">
                    <div class="text-lg font-medium text-gray-900 dark:text-white" id="currentTime"></div>
                </div>

                <!-- Map Section -->
                <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg mb-6">
                    <div id="map" class="h-64 w-full rounded-lg shadow"></div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('trips') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Back</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map Scripts -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-rotatedmarker@0.2.0/leaflet.rotatedMarker.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Inisialisasi peta
            var map = L.map("map").setView([{{ $tripsList->vehicle->gps->latitude }}, {{ $tripsList->vehicle->gps->longitude }}], 12);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 18,
            }).addTo(map);

            // Ambil lokasi start, end, dan vehicle
            const startCompany = {!! json_encode($companyList->where('name', $tripsList->start_location)->first()) !!};
            const endCompany = {!! json_encode($companyList->where('name', $tripsList->end_location)->first()) !!};
            const vehicle = {!! json_encode($tripsList->vehicle) !!};
            const startTime = new Date('{{ $tripsList->start_time }}');
            const endTime = new Date('{{ $tripsList->end_time }}');

            // Tambahkan marker untuk vehicle
            const vehicleIcon = L.icon({
                iconUrl: "https://cdn-icons-png.flaticon.com/512/854/854894.png",
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            const vehicleMarker = L.marker([vehicle.gps.latitude, vehicle.gps.longitude], {
                icon: vehicleIcon,
                rotationOrigin: 'center center'
            }).addTo(map);

            // Tambahkan marker untuk start & end
            if (startCompany) {
                L.marker([startCompany.latitude, startCompany.longitude], {
                    icon: L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })
                }).addTo(map).bindPopup("Start: " + startCompany.name);
            }

            if (endCompany) {
                L.marker([endCompany.latitude, endCompany.longitude], {
                    icon: L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png",
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })
                }).addTo(map).bindPopup("End: " + endCompany.name);
            }

            // Fetch rute perjalanan
            fetch(`https://router.project-osrm.org/route/v1/driving/${vehicle.gps.longitude},${vehicle.gps.latitude};${startCompany.longitude},${startCompany.latitude};${endCompany.longitude},${endCompany.latitude}?overview=full&geometries=geojson`)
                .then(response => response.json())
                .then(data => {
                    if (!data.routes.length) {
                        console.error("Route not found!");
                        return;
                    }

                    // Ambil koordinat rute
                    const routeCoordinates = data.routes[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);

                    // Tambahkan garis rute ke peta
                    L.polyline(routeCoordinates, { color: "blue", weight: 3, opacity: 0.5 }).addTo(map);
                    map.fitBounds(L.latLngBounds(routeCoordinates));

                    // Total durasi perjalanan dalam milidetik
                    const tripDuration = endTime - startTime;

                    // Fungsi perhitungan heading (arah kendaraan)
                    function calculateBearing(start, end) {
                        const startLat = start[0] * Math.PI / 180;
                        const startLng = start[1] * Math.PI / 180;
                        const endLat = end[0] * Math.PI / 180;
                        const endLng = end[1] * Math.PI / 180;

                        const y = Math.sin(endLng - startLng) * Math.cos(endLat);
                        const x = Math.cos(startLat) * Math.sin(endLat) -
                                Math.sin(startLat) * Math.cos(endLat) * Math.cos(endLng - startLng);

                        const bearing = Math.atan2(y, x) * 180 / Math.PI;
                        return (bearing + 360) % 360;
                    }

                    // Animasi marker vehicle
                    let currentIndex = 0;
                    let startTimestamp = null;

                    function animateMarker(timestamp) {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const elapsed = timestamp - startTimestamp;

                        // Hitung progress berdasarkan waktu
                        let progress = elapsed / tripDuration;
                        if (progress >= 1) {
                            vehicleMarker.setLatLng(routeCoordinates[routeCoordinates.length - 1]);
                            return; // Hentikan animasi saat perjalanan selesai
                        }

                        // Hitung posisi interpolasi
                        let positionIndex = Math.floor(progress * (routeCoordinates.length - 1));
                        let nextIndex = Math.min(positionIndex + 1, routeCoordinates.length - 1);

                        let currentPos = routeCoordinates[positionIndex];
                        let nextPos = routeCoordinates[nextIndex];

                        // Interpolasi antara dua titik
                        let lat = currentPos[0] + (nextPos[0] - currentPos[0]) * (progress * (routeCoordinates.length - 1) % 1);
                        let lng = currentPos[1] + (nextPos[1] - currentPos[1]) * (progress * (routeCoordinates.length - 1) % 1);

                        vehicleMarker.setLatLng([lat, lng]);

                        // Update arah kendaraan
                        if (positionIndex < routeCoordinates.length - 1) {
                            let bearing = calculateBearing(currentPos, nextPos);
                            vehicleMarker.setRotationAngle(bearing);
                        }

                        requestAnimationFrame(animateMarker);
                    }

                    requestAnimationFrame(animateMarker);
                })
                .catch(error => console.error("Error fetching route:", error));
        });     
    </script>
</x-app-layout>