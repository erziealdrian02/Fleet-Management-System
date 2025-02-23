<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <a href="{{ route('company') }}" class="hover:text-gray-700 dark:hover:text-gray-300">Gps Trackings</a>
                <span>›</span>
                <span>Edit</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8">Edit Gps Tracking</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form action="{{ route('company.update', $companyList->id) }}" method="POST">
                    @csrf
            
                    <!-- Vehicle & Speed Selection -->
                    <div class="mb-6 flex space-x-4">
                        <div class="w-1/2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Name<span class="text-red-600">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required value="{{ $companyList->name }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type<span class="text-red-600">*</span>
                            </label>
                            <select name="type" id="type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required>  
                                <option value="">Select Type</option>  
                                @foreach(['Vendor', 'Head Office', 'Mitra', 'Supplier', 'Rekanan', 'Distributor'] as $type)  
                                    <option value="{{ $type }}" {{ (old('type') == $type || ($companyList->type ?? '') == $type) ? 'selected' : '' }}>{{ $type }}</option>  
                                @endforeach  
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address<span class="text-red-600">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required>{{ $companyList->alamat }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- GPS Location Section with Map -->
                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg mb-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Lokasi GPS</h2>
            
                        <div id="map" class="h-64 w-full rounded-lg shadow"></div>
                        
                        <div class="flex space-x-4 mt-4">
                            <div class="w-1/2">
                                <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Latitude<span class="text-red-600">*</span></label>
                                <input type="number" step="any" name="latitude" id="latitude" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required value="{{ $companyList->latitude }}" readonly>
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-1/2">
                                <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Longitude<span class="text-red-600">*</span></label>
                                <input type="number" step="any" name="longitude" id="longitude" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-orange-500 focus:ring-orange-500" required value="{{ $companyList->longitude }}" readonly>
                                @error('longitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
            
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('company') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Cancel</a>
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
            // Ambil koordinat dari Blade atau gunakan default jika kosong
            var lat = {{ $companyList->latitude ?? -6.200000 }};
            var lng = {{ $companyList->longitude ?? 106.816666 }};
    
            var map = L.map("map").setView([lat, lng], 12);
    
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 18,
            }).addTo(map);
    
            // Tambahkan marker berdasarkan koordinat yang sudah ada
            var marker = L.marker([lat, lng], { draggable: true }).addTo(map);
    
            // Perbarui input saat marker dipindahkan
            marker.on("dragend", function (e) {
                var lat = marker.getLatLng().lat.toFixed(6);
                var lng = marker.getLatLng().lng.toFixed(6);
    
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            });
    
            // Perbarui marker dan input saat peta diklik
            map.on("click", function (e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);
    
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
    
                marker.setLatLng(e.latlng);
            });
        });
    </script>    
</x-app-layout>