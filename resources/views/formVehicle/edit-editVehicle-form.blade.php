<x-modal name="vehicle-modal" focusable maxWidth="4xl">
    <form x-bind:action="isEdit 
        ? '{{ route('vehicle.update', '') }}/' + vehicleId 
        : '{{ route('vehicle.store') }}'" 
        method="POST" 
        class="p-6"
    >
        @csrf
        <template x-if="isEdit">
            @method('PUT')
        </template>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit vehicle') }}
            </h2>
            <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Vehicle Name Input -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- License Plate -->
            <div>
                <x-input-label for="license_plate" :value="__('License plate')" required />
                <x-text-input 
                    id="license_plate" 
                    name="license_plate" 
                    type="text" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="vehiclePlate"
                />
            </div>

            <!-- Type -->
            <div>
                <x-input-label for="type" :value="__('Type')" required />
                <x-text-input 
                    id="type" 
                    name="type" 
                    type="text" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="vehicleType"
                />
            </div>

            <!-- Status -->
            <div>
                <x-input-label for="status" :value="__('Status')" required />
                <select 
                    id="status" 
                    name="status" 
                    class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white focus:border-orange-500 focus:ring-orange-500"
                    required
                    x-model="vehicleStat"
                >
                    <option value="Aktif">Aktif</option>
                    <option value="Perawatan">Perawatan</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <!-- Fuel Capacity -->
            <div>
                <x-input-label for="fuel_capacity" :value="__('Fuel capacity')" required />
                <x-text-input 
                    id="fuel_capacity" 
                    name="fuel_capacity" 
                    type="number" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="vehicleFuel"
                />
            </div>

            <!-- Last Service Date -->
            <div>
                <x-input-label for="last_service_date" :value="__('Last service date')" />
                <x-text-input 
                    id="last_service_date" 
                    name="last_service_date" 
                    type="date" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    placeholder="mm/dd/yyyy"
                    x-model="vehicleLastService"
                />
            </div>

            <!-- Mileage -->
            <div>
                <x-input-label for="mileage" :value="__('Mileage')" required />
                <x-text-input 
                    id="mileage" 
                    name="mileage" 
                    type="number" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    placeholder="0"
                    required 
                    x-model="vehicleMileage"
                />
            </div>
        </div>

        <!-- GPS Toggle -->
        <div class="mt-6">
            <label class="inline-flex items-center">
                <input 
                    type="checkbox" 
                    name="gps_enabled" 
                    class="rounded bg-gray-800 border-gray-700 text-orange-500 focus:ring-orange-500"
                >
                <span class="ml-2 text-gray-300">GPS enabled</span>
            </label>
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex justify-Start">
            <x-info-button type="submit" class="bg-orange-500 hover:bg-orange-600 mr-2">
                {{ __('Create') }}
            </x-info-button>

            <x-secondary-button type="button" x-on:click="$dispatch('close')" class="bg-gray-700 hover:bg-gray-600 text-white">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>