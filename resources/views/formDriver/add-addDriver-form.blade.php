<section class="space-y-6" x-data="{ open: false }">
    <x-info-button
        class="mt-4"
        x-on:click.prevent="$dispatch('open-modal', 'create-driver-modal')"
    >{{ __('New Driver') }}</x-info-button>

    <x-modal name="create-driver-modal" focusable maxWidth="4xl">
        <form method="POST" action="{{ route('driver.store') }}" class="p-6">
            @csrf

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Create Driver') }}
                </h2>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

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
                    >
                        <option value="">No Vehicle</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} - {{ $vehicle->type }}</option>
                        @endforeach
                    </select>
                </div>
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