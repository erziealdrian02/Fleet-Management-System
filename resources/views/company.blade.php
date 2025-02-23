<!-- resources/views/vehicles/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <span>{{ $title }}</span>
                <span>›</span>
                <span>List</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8">{{ $title }}</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <!-- Header Actions -->
                <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4">
                        <x-link-button-info class="mt-4" href="{{ route('company.from-add') }}">
                            {{ __('New vehicle') }}
                        </x-link-button-info>
                    </div>
                </div>

                @if (session('success'))  
                    <div class="bg-emerald-600 text-white font-bold px-4 py-2">  
                        {{ session('success') }}  
                    </div>  
                @endif  
                @if (session('error'))  
                    <div class="bg-red-600 text-white font-bold px-4 py-2">  
                        {{ session('error') }}  
                    </div>  
                @endif 

                <!-- Search Bar -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 relative">
                            <input type="text" placeholder="Search" class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <button class="p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase company-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase company-wider">
                                    Alamat
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase company-wider">
                                    Type of Company
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($companyList as $company)
                                <tr onclick="toggleDetails({{ $company->id }})" class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $company->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $company->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center gap-2">
                                            <x-link-button-info href="{{ route('company.from-edit', $company->id) }}">
                                                <x-heroicon-o-pencil-square class="w-4 h-4"/>
                                            </x-link-button-info>                                        
                                    
                                            <x-danger-button onclick="confirmDelete({{ $company->id }})">  
                                                <x-heroicon-o-trash class="w-4 h-4"/>
                                            </x-danger-button>  
                                        </div>
                                    
                                        <form id="delete-form-{{ $company->id }}" action="{{ route('company.delete', $company->id) }}" method="POST" style="display: none;">  
                                            @csrf  
                                            @method('DELETE')  
                                        </form>  
                                    </td>                                    
                                    <!-- Tambahkan Icon Panah untuk Toggle -->
                                    <td class="px-6 py-4 text-center">
                                        <svg id="icon-{{ $company->id }}" class="w-5 h-5 transition-transform duration-200 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </td>
                                </tr>

                                <tr id="details-{{ $company->id }}" class="hidden bg-gray-50 dark:bg-gray-900">
                                    <td colspan="5" class="px-6 py-4">
                                        <div class="mb-4 flex justify-between items-center">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    Company Name: <span class="text-sm">{{ $company->name }}</span>
                                                </h3>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    Company Type: <span class="text-sm">{{ $company->type }}</span>
                                                </h3>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    Company Address: <span class="text-sm">{{ $company->alamat }}</span>
                                                </h3>
                                            </div>
                                        </div>

                                        <!-- Peta company -->
                                        <div id="map-{{ $company->id }}" class="h-64 w-full rounded-lg shadow"></div>

                                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                                        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                var companyId = {{ $company->id }};
                                                var lat = {{ $company->latitude }};
                                                var lng = {{ $company->longitude }};
                                                var mapContainerId = "map-" + companyId;

                                                if (document.getElementById(mapContainerId)) {
                                                    var map = L.map(mapContainerId, { center: [lat, lng], zoom: 12 });

                                                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                                                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                                                        maxZoom: 18,
                                                    }).addTo(map);

                                                    var marker = L.marker([lat, lng]).addTo(map);
                                                    
                                                    // Perbaikan: Pusatkan ulang peta ke koordinat marker
                                                    map.setView([lat, lng], 15); // 15 bisa disesuaikan dengan level zoom yang lebih cocok
                                                }
                                            });


                                            function toggleDetails(id) {
                                                var detailsRow = document.getElementById("details-" + id);
                                                var icon = document.getElementById("icon-" + id);

                                                if (!detailsRow) {
                                                    console.error("Element with ID 'details-" + id + "' not found.");
                                                    return;
                                                }

                                                detailsRow.classList.toggle("hidden");

                                                // Putar ikon panah saat toggle
                                                if (icon) {
                                                    icon.classList.toggle("rotate-180");
                                                }
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @empty  
                                <tr class="bg-white border-b dark:bg-gray-800 text-gray-800 dark:text-white">
                                    <td colspan="8" class="px-6 py-4 text-center">Tidak ada data transaksi.</td>  
                                </tr>  
                            @endforelse 
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Showing 1 result
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Per page</span>
                            <select class="rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     

    {{-- Script Konfirmasi Hapus --}}
    <script>  
        function confirmDelete(driverId) {  
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {  
                document.getElementById('delete-form-' + driverId).submit();  
            }  
        }  
    </script>
</x-app-layout>