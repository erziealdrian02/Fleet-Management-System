<section class="space-y-6" x-data="{ open: false }">
    <x-info-button
        class="mt-4"
        x-on:click.prevent="$dispatch('open-modal', 'create-vehicle-modal')"
    >{{ __('New vehicle') }}</x-info-button>

    <x-modal name="create-vehicle-modal" focusable maxWidth="4xl">
        <form method="POST" action="{{ route('vehicle.store') }}" class="p-6">
            @csrf

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Create vehicle') }}
                </h2>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

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

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-start space-x-3">
                <x-info-button type="submit" class="bg-orange-500 hover:bg-orange-600">
                    {{ __('Create') }}
                </x-info-button>

                <x-secondary-button type="button" x-on:click="$dispatch('close')" class="bg-gray-700 hover:bg-gray-600 text-white">
                    {{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </form>
    </x-modal>
</section>