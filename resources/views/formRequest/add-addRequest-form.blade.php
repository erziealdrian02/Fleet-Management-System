<section class="space-y-6" x-data="{ open: false, items: [] }">
    <x-info-button
        class="mt-4 mb-4"
        x-on:click.prevent="$dispatch('open-modal', 'add-transaction-modal')"
    >{{ __('Request Spare Parts') }}</x-info-button>

    <x-modal name="add-transaction-modal" x-show="open" focusable maxWidth="wide">
        <form method="POST" action="{{ route('requestPart.store') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Request Spare Parts Baru') }}
            </h2>

            <!-- Vehicle -->
            <div>
                <x-input-label for="vehicle_id" :value="__('Assign Vehicle (Optional)')" />
                <select 
                    id="vehicle_id" 
                    name="vehicle_id" 
                    class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white focus:border-orange-500 focus:ring-orange-500"
                >
                    <option value="">No Vehicle</option>
                    @foreach ($vehicleList as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} - {{ $vehicle->type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Input Kode Transaksi -->
            <div class="mt-4" x-data="{ kodeTransaksi: '{{ $newCode }}' }">
                <x-input-label for="kode_transaksi" value="Kode Transaksi" />
                <x-text-input id="kode_transaksi" name="kode_transaksi" type="text" class="w-full" x-model="kodeTransaksi" readonly />
            </div>    

            <!-- Input Tanggal -->
            <div class="mt-4">
                <x-input-label for="tanggal" value="Tanggal Transaksi" />
                <x-text-input id="tanggal" name="tanggal" type="date" class="w-full" required />
            </div>

            <script>
                const produkStokMapTransaction = @json($partList->pluck('stock_quantity', 'id'));
                const produkHargaMapTransaction = @json($partList->pluck('price', 'id'));
                
                function formatNumber(num) {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            </script>
            
            <!-- Produk List -->
            <div class="mt-4">
                <h3 class="text-md font-semibold">Daftar Produk</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-500 dark:text-gray-400 mt-2">
                        <thead>
                            <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th class="px-3 py-2 w-2/5">Produk</th>
                                <th class="px-2 py-2 text-center w-1/6">Qty</th>
                                <th class="px-2 py-2 text-center w-1/6">Harga</th>
                                <th class="px-2 py-2 text-center w-1/6">Total</th>
                                <th class="px-2 py-2 text-center w-1/12">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="px-3 py-2">
                                        <x-select-input
                                            name="produk[]"
                                            x-model="item.id_parts"
                                            x-on:change="
                                                item.price = produkHargaMapTransaction[item.id_parts] || 0;
                                                item.maxStok = produkStokMapTransaction[item.id_parts] || 0;
                                                if (item.stock_quantity > item.maxStok) item.stock_quantity = item.maxStok;
                                                item.formattedPrice = formatNumber(item.price);
                                            "
                                            class="w-full text-sm"
                                            :placeholder="'Pilih Produk'"
                                        >
                                            <option value="">Pilih Produk</option>
                                            @foreach ($partList as $parts)
                                                <option value="{{ $parts->id }}" @if ($parts->stock_quantity == 0) disabled @endif>
                                                    {{ $parts->name }} @if ($parts->stock_quantity == 0) (Stok Habis) @endif
                                                </option>
                                            @endforeach
                                        </x-select-input>
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <x-text-input 
                                            id="quantity[]" 
                                            x-model="item.stock_quantity" 
                                            name="quantity[]" 
                                            type="number" 
                                            class="w-full text-center text-sm" 
                                            min="1"
                                            x-bind:max="item.maxStok" 
                                            required
                                        />
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                            <x-text-input 
                                                id="harga[]" 
                                                x-model="item.price" 
                                                name="harga[]" 
                                                type="text" 
                                                class="w-full pl-8 text-right text-sm" 
                                                readonly 
                                                x-on:input="
                                                    item.price = item.price.replace(/\D/g, '');
                                                    item.formattedPrice = formatNumber(item.price);
                                                "
                                                required
                                            />
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-right">
                                        <div class="text-gray-700 dark:text-gray-400 whitespace-nowrap">
                                            Rp <span x-text="formatNumber(item.stock_quantity * item.price || 0)"></span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <button type="button" x-on:click="items.splice(index, 1)" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Total Keseluruhan -->
            <div class="mt-4 text-right">
                <div class="font-semibold">
                    Total: Rp <span x-text="formatNumber(items.reduce((total, item) => total + (item.stock_quantity * item.price || 0), 0))"></span>
                </div>
            </div>

            <!-- Tombol Tambah Produk -->
            <div class="mt-4">
                <button type="button" x-on:click="items.push({ id_parts: '', stock_quantity: 1, price: 0, maxStok: 0 })" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm">
                    + Tambah Produk
                </button>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-info-button type="submit" class="ms-3">
                    {{ __('Simpan') }}
                </x-info-button>
            </div>
        </form>
    </x-modal>
</section>