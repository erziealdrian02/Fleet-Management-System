<x-modal name="sparepart-modal" focusable maxWidth="4xl">
    <form x-bind:action="isEdit 
        ? '{{ route('spareparts.update', '') }}/' + spareId 
        : '{{ route('spareparts.store') }}'" 
        method="POST" 
        class="p-6"
        @submit="price = price.replace(/\./g, '')"
    >
        @csrf
        <template x-if="isEdit">
            @method('PUT')
        </template>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Spare Parts') }}
            </h2>
            <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Driver Name Input -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">  
            <!-- Stock Name -->  
            <div>  
                <x-input-label for="name" :value="__('Stock Name')" required />  
                <x-text-input   
                    id="name"   
                    name="name"   
                    type="text"   
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"   
                    x-model="spareName"
                    required   
                />  
            </div>  

            <!-- Part Number -->  
            <div>  
                <x-input-label for="part_number" :value="__('Part Number')" required />  
                <x-text-input   
                    id="part_number"   
                    name="part_number"   
                    type="text"   
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"   
                    x-model="sparePartNumber"
                    required   
                />  
            </div>  

            <!-- Stock Quantity -->  
            <div>  
                <x-input-label for="stock_quantity" :value="__('Stock Quantity')" required />  
                <x-text-input   
                    id="stock_quantity"   
                    name="stock_quantity"   
                    type="number"   
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"   
                    x-model="spareStock"
                    required   
                />  
            </div>  

            <!-- Price -->  
            <div>  
                <x-input-label for="price" :value="__('Price')" required />  
                <div class="flex items-center border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                    <span class="px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">Rp</span>
                    <x-text-input   
                        id="price"   
                        name="price"   
                        type="text"   
                        x-model="price"  
                        x-on:input="price = price.replace(/\D/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')"  
                        class="block w-full bg-gray-800 border-gray-700 text-white"   
                        x-model="sparePrice"
                        required   
                    />  
                </div>
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