<x-modal name="driver-modal" focusable maxWidth="4xl">
    <form x-bind:action="isEdit 
        ? '{{ route('driver.update', '') }}/' + driverId 
        : '{{ route('driver.store') }}'" 
        method="POST" 
        class="p-6"
    >
        @csrf
        <template x-if="isEdit">
            @method('PUT')
        </template>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Driver') }}
            </h2>
            <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Driver Name Input -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" required />
                <x-text-input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="driverName"
                />
            </div>

            <!-- License Number -->
            <div>
                <x-input-label for="license_number" :value="__('License Number')" required />
                <x-text-input 
                    id="license_number" 
                    name="license_number" 
                    type="number" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="driverLicense"
                />
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" required />
                <x-text-input 
                    id="phone_number" 
                    name="phone_number" 
                    type="number" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="driverPhone"
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
                    x-model="driverStatus"
                >
                    <option value="Aktif">Aktif</option>
                    <option value="Libur">Libur</option>
                    <option value="Diberhentikan">Diberhentikan</option>
                </select>
            </div>

            <!-- Assigned Vehicle -->
            <div>
                <x-input-label for="assigned_vehicle_id" :value="__('Assign Vehicle (Optional)')" />
                <select 
                    id="assigned_vehicle_id" 
                    name="assigned_vehicle_id" 
                    class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white focus:border-orange-500 focus:ring-orange-500"
                    x-model="driverAssigned"
                >
                    <option value="">No Vehicle</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} - {{ $vehicle->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex justify-end">
            <x-secondary-button type="button" x-on:click="$dispatch('close')" class="bg-gray-700 hover:bg-gray-600 text-white">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-info-button type="submit" class="ms-3">
                {{ __('Save') }}
            </x-info-button>
        </div>
    </form>
</x-modal>