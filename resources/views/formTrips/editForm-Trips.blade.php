<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <a href="{{ route('trips') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Gps Trackings</a>
                <span>›</span>
                <span>Create</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8">Create Gps Tracking</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form action="{{ route('trips.store') }}" method="POST">
                    @csrf
                    <!-- Vehicle & Speed Selection -->
                    <div class="mb-6 flex space-x-4">
                        <div class="w-1/2">
                            <label for="driver_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Driver<span class="text-red-600">*</span>
                            </label>
                            <select name="driver_id" id="driver_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required>
                                <option value="">Select an option</option>
                                @foreach($driverList as $driver)
                                    <option value="{{ $driver->id }}"
                                        @if($tripsList->driver_id == $driver->id) selected @endif> 
                                        {{ $driver->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="w-1/2">
                            <label for="vehicle_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Vehicle<span class="text-red-600">*</span>
                            </label>
                            <select name="vehicle_id" id="vehicle_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required>
                                <option value="">Select an option</option>
                                @foreach($vehicleList as $vehicle)
                                    <option value="{{ $vehicle->id }}" 
                                        data-lat="{{ $vehicle->gps ? $vehicle->gps->latitude : '' }}" 
                                        data-lng="{{ $vehicle->gps ? $vehicle->gps->longitude : '' }}"
                                        data-speed="{{ $vehicle->gps ? $vehicle->gps->speed : '' }}"
                                        @if($tripsList->vehicle_id == $vehicle->id) selected @endif>
                                        {{ $vehicle->license_plate }} - {{ $vehicle->type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <h1>{{ $vehicle->gps->longitude }}</h1>
                    <div class="mb-6 flex space-x-4">
                        <div class="w-1/2">
                            <label for="start_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Location<span class="text-red-600">*</span>
                            </label>
                            <select name="start_location" id="start_location" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required>
                                <option value="">Select an option</option>
                                @foreach($companyList as $company)
                                    <option value="{{ $company->name }}" data-name="{{ $company->name }}" data-lat="{{ $company->latitude }}" data-lng="{{ $company->longitude }}"
                                        @if($tripsList->start_location == $company->name) selected @endif>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('start_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="w-1/2">
                            <label for="end_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                End Location<span class="text-red-600">*</span>
                            </label>
                            <select name="end_location" id="end_location" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required>
                                <option value="">Select an option</option>
                                @foreach($companyList as $company)
                                    <option value="{{ $company->name }}" data-name="{{ $company->name }}" data-lat="{{ $company->latitude }}" data-lng="{{ $company->longitude }}"
                                        @if($tripsList->start_location == $company->name) selected @endif>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('end_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6 flex space-x-4">
                        <div class="w-1/2">
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Time<span class="text-red-600">*</span>
                            </label>
                            <input type="datetime-local" step="any" name="start_time" id="start_time" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required value="{{ $tripsList->start_time }}">
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="w-1/2">
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                End Time<span class="text-red-600">*</span>
                            </label>
                            <input type="datetime-local" step="any" name="end_time" id="end_time" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required value="{{ $tripsList->end_time }}">
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-1/2">
                            <label for="distance" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Distance (km)<span class="text-red-600">*</span>
                            </label>
                            <input type="number" step="any" name="distance" id="distance" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required value="{{ $tripsList->distance }}" readonly>
                            @error('distance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
            
                    <!-- GPS Location Section with Map -->
                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg mb-6">
                        <div id="map" class="h-64 w-full rounded-lg shadow"></div>
                    </div>
            
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('trips') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Cancel</a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Leaflet Map Scripts -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var map = L.map("map").setView([{{ $latitude }}, {{ $longitude }}], 12);
    
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 18,
            }).addTo(map);
    
            let startMarker = null;
            let endMarker = null;
            let vehicleMarker = null;
            let routeLayer = null;
            let routeLayerVehicle = null;
    
            function updateRoute() {
                const vehicleSelect = document.querySelector("#vehicle_id option:checked");
                const startSelect = document.querySelector("#start_location option:checked");
                const endSelect = document.querySelector("#end_location option:checked");
    
                // Cek apakah ada vehicle yang dipilih
                if (vehicleSelect || startSelect || endSelect) return;
    
                const vehicleLat = {{ $vehicle->gps->latitude }};
                const vehicleLng = {{ $vehicle->gps->longitude }};
                const startName = startSelect.dataset.name;
                const startLat = startSelect.dataset.lat;
                const startLng = startSelect.dataset.lng;
                const endName = endSelect.dataset.name;
                const endLat = endSelect.dataset.lat;
                const endLng = endSelect.dataset.lng;
    
                // Hapus marker lama jika ada
                if (vehicleMarker) map.removeLayer(vehicleMarker);
                if (startMarker) map.removeLayer(startMarker);
                if (endMarker) map.removeLayer(endMarker);
    
                // Tambahkan marker Vehicle (Gunakan ikon mobil)
                if (vehicleLat && vehicleLng) {
                    vehicleMarker = L.marker([vehicleLat, vehicleLng], { icon: L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/854/854894.png", // Ikon mobil
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })}).addTo(map).bindPopup("Vehicle Position").openPopup();
                }
    
                // Tambahkan marker Start
                if (startLat && startLng) {
                    startMarker = L.marker([startLat, startLng], { icon: L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png", // Ikon start
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })}).addTo(map).bindPopup("Start: " + startName).openPopup();
                }
    
                // Tambahkan marker End
                if (endLat && endLng) {
                    endMarker = L.marker([endLat, endLng], { icon: L.icon({
                        iconUrl: "https://cdn-icons-png.flaticon.com/512/684/684908.png", // Ikon end
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })}).addTo(map).bindPopup("End: " + endName).openPopup();
                }
    
                // Ambil rute dari Vehicle ke Start
                if (vehicleLat && vehicleLng && startLat && startLng) {
                    if (routeLayerVehicle) map.removeLayer(routeLayerVehicle);
    
                    const routeURLVehicle = `https://router.project-osrm.org/route/v1/driving/${vehicleLng},${vehicleLat};${startLng},${startLat}?overview=full&geometries=geojson`;
    
                    fetch(routeURLVehicle)
                        .then(response => response.json())
                        .then(data => {
                            const routeCoords = data.routes[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
                            routeLayerVehicle = L.polyline(routeCoords, { color: "red", weight: 5 }).addTo(map);
                            map.fitBounds(routeLayerVehicle.getBounds());
                        })
                        .catch(err => console.error("Error fetching vehicle route:", err));
                }
    
                // Ambil rute dari Start ke End
                if (startLat && startLng && endLat && endLng) {
                    if (routeLayer) map.removeLayer(routeLayer);
    
                    const routeURL = `https://router.project-osrm.org/route/v1/driving/${startLng},${startLat};${endLng},${endLat}?overview=full&geometries=geojson`;
    
                    fetch(routeURL)
                        .then(response => response.json())
                        .then(data => {
                            const routeCoords = data.routes[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
                            routeLayer = L.polyline(routeCoords, { color: "blue", weight: 5 }).addTo(map);
                            map.fitBounds(routeLayer.getBounds());
                        })
                        .catch(err => console.error("Error fetching route:", err));
                }
            }
    
            document.getElementById("vehicle_id").addEventListener("change", updateRoute);
            document.getElementById("start_location").addEventListener("change", updateRoute);
            document.getElementById("end_location").addEventListener("change", updateRoute);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const vehicleSelect = document.getElementById("vehicle_id");
            const startSelect = document.getElementById("start_location");
            const endSelect = document.getElementById("end_location");
            const distanceInput = document.getElementById("distance");

            function updateDistance() {
                const vehicleOption = vehicleSelect.options[vehicleSelect.selectedIndex];
                const startOption = startSelect.options[startSelect.selectedIndex];
                const endOption = endSelect.options[endSelect.selectedIndex];

                if (!vehicleOption || !startOption || !endOption) return;

                const vehicleLat = vehicleOption.dataset.lat;
                const vehicleLng = vehicleOption.dataset.lng;
                const startLat = startOption.dataset.lat;
                const startLng = startOption.dataset.lng;
                const endLat = endOption.dataset.lat;
                const endLng = endOption.dataset.lng;

                console.log("Vehicle:", vehicleLat, vehicleLng);
                console.log("Start:", startLat, startLng);
                console.log("End:", endLat, endLng);

                if (startLat && startLng && endLat && endLng) {
                    let routeURL = `https://router.project-osrm.org/route/v1/driving/${startLng},${startLat};${endLng},${endLat}?overview=false&geometries=geojson`;

                    if (vehicleLat && vehicleLng) {
                        routeURL = `https://router.project-osrm.org/route/v1/driving/${vehicleLng},${vehicleLat};${startLng},${startLat};${endLng},${endLat}?overview=false&geometries=geojson`;
                    }

                    fetch(routeURL)
                        .then(response => response.json())
                        .then(data => {
                            if (data.routes.length > 0) {
                                const distanceKm = (data.routes[0].distance / 1000).toFixed(2);
                                distanceInput.value = distanceKm;
                            } else {
                                console.error("No route found");
                            }
                        })
                        .catch(err => console.error("Error fetching distance:", err));
                }
            }

            vehicleSelect.addEventListener("change", updateDistance);
            startSelect.addEventListener("change", updateDistance);
            endSelect.addEventListener("change", updateDistance);
        });
    </script>
             

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const driverSelect = document.getElementById("driver_id");
            const vehicleSelect = document.getElementById("vehicle_id");
        
            driverSelect.addEventListener("change", function () {
                const selectedOption = driverSelect.options[driverSelect.selectedIndex];
                const assignedVehicleId = selectedOption.getAttribute("data-assigned-vehicle");
        
                if (assignedVehicleId && assignedVehicleId !== "null") {
                    // Jika ada assigned_vehicle_id, pilih kendaraan yang sesuai
                    for (let option of vehicleSelect.options) {
                        if (option.value === assignedVehicleId) {
                            option.selected = true;
                            return; // Stop di sini agar tidak menjalankan else di bawahnya
                        }
                    }
                } 
                
                // Jika tidak ada assigned_vehicle_id atau bernilai null, reset dropdown vehicle
                vehicleSelect.value = "";
            });
        });
    </script>
    
    
</x-app-layout>