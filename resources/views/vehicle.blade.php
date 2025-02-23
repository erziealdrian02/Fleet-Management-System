<!-- resources/views/vehicles/index.blade.php -->
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <span>Vehicles</span>
                <span>›</span>
                <span>List</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8">Vehicles</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow" x-data="{
                isEdit: false,
                vehiclePlate: '', 
                vehicleType: '',
                vehicleStat: '',
                vehicleFuel: '',
                vehicleLastService: '',
                vehicleMileage: '',
                vehicleGPS: '',
                vehicleId: '',

                initEdit(vehicles) {
                    this.isEdit = true;
                    this.vehiclePlate = vehicles.license_plate;
                    this.vehicleType = vehicles.type;
                    this.vehicleStat = vehicles.status;
                    this.vehicleFuel = vehicles.fuel_capacity;
                    this.vehicleLastService = vehicles.last_service_date;
                    this.vehicleMileage = vehicles.mileage;
                    this.vehicleGPS = vehicles.gps_enabled;
                    this.vehicleId = vehicles.id;
                    this.$dispatch('open-modal', 'vehicle-modal');
                }
            }">
                <!-- Header Actions -->
                <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4">
                        @include('formVehicle.add-addVehicle-form')
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Plat Nomor
                                    <button class="ml-1 text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Tipe Manajemen Kendaraan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kapasitas Bahan Bakar (L)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Terakhir Servis
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kilometer
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    GPS
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($vehicleList as $vehicles)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{-- {{ $loop->iteration }} --}}
                                        {{ $vehicles->license_plate }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $vehicles->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $vehicles->status == 'Aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                               ($vehicles->status == 'Perawatan' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                               'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                            {{ $vehicles->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $vehicles->fuel_capacity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $vehicles->last_service_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $vehicles->mileage }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if ($vehicles->gps_enabled)
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- <a href="#" class="text-orange-500 hover:text-orange-600">
                                            Edit
                                        </a> --}}

                                        <x-warning-button x-on:click="initEdit({{ $vehicles }})">
                                            <x-heroicon-o-pencil-square class="w-4 h-4"/>
                                        </x-warning-button>                                        

                                        <x-danger-button onclick="confirmDelete({{ $vehicles->id }})">  
                                            <x-heroicon-o-trash class="w-4 h-4"/>
                                        </x-danger-button>  

                                        <form id="delete-form-{{ $vehicles->id }}" action="{{ route('vehicle.delete', $vehicles->id) }}" method="POST" style="display: none;">  
                                            @csrf  
                                            @method('DELETE')  
                                        </form>  
                                    </td>
                                </tr>
                            @empty  
                                <tr class="bg-white border-b dark:bg-gray-800">
                                    <td colspan="8" class="px-6 py-4 text-center">Tidak ada data transaksi.</td>  
                                </tr>  
                            @endforelse  
                        </tbody>
                    </table>
                </div>

                @include('formVehicle.edit-editVehicle-form')

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
        function confirmDelete(vehiclesId) {  
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {  
                document.getElementById('delete-form-' + vehiclesId).submit();  
            }  
        }  
    </script>
</x-app-layout>