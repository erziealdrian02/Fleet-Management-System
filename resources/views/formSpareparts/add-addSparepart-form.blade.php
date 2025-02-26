<section class="space-y-6" x-data="{ open: false, price: '' }">  
    <x-info-button  
        class="mt-4"  
        x-on:click.prevent="$dispatch('open-modal', 'create-spareparts-modal')"  
    >{{ __('Add Stock Spare Part') }}</x-info-button>  

    <x-modal name="create-spareparts-modal" focusable maxWidth="4xl">  
        <form method="POST" action="{{ route('spareparts.store') }}" class="p-6" @submit="price = price.replace(/\./g, '')">  
            @csrf  

            <div class="flex justify-between items-center mb-6">  
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">  
                    {{ __('Add Stock Spare Part') }}  
                </h2>  
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">  
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">  
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>  
                    </svg>  
                </button>  
            </div>  

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">  
                <!-- Stock Name -->  
                <div>  
                    <x-input-label for="name" :value="__('Stock Name')" required />  
                    <x-text-input   
                        id="name"   
                        name="name"   
                        type="text"   
                        class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"   
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
                            required   
                        />  
                    </div>
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