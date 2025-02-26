<section class="space-y-6" x-data="{ 
    open: false, 
    items: [], 
    kodeTransaksi: '', 
    tanggalTransaksi: '',
    idTransaksi: '',
    initializeItems() {
    const details = {{ Js::from($transaksi->detailTransaksi ?? []) }};
    this.items = details.map(detail => ({
        id_produk: detail.produk.id,
        quantity: detail.quantity,
        harga: detail.produk.harga
    }));
}
}">
    <x-info-button
        class="mt-4"
        x-on:click.prevent="
            kodeTransaksi = '{{ $transaksi->kode_transaksi }}'; 
            tanggalTransaksi = '{{ date('Y-m-d', strtotime($transaksi->tanggal)) }}';
            idTransaksi = '{{ $transaksi->id }}'; 
            initializeItems();
            console.log('Items:', items); // Debugging
            $dispatch('open-modal', 'add-product-modal')
        "
        >
        {{ __('Edit Transaksi') }}
    </x-info-button>

    <x-modal name="add-product-modal" x-show="open" focusable maxWidth="4xl">
        <form method="POST" action="{{ route('transaction.storeProduct') }}" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Transaksi') }} <span x-text="kodeTransaksi"></span>
            </h2>

            <!-- Input Kode Transaksi (Auto) -->
            <div class="mt-4">
                <x-input-label for="kode_transaksi" value="Kode Transaksi" />
                <x-text-input id="kode_transaksi" name="kode_transaksi" type="text" class="w-full" x-model="kodeTransaksi" readonly />
            </div>    

            <!-- Input Tanggal Transaksi (Auto) -->
            <div class="mt-4">
                <x-input-label for="tanggal" value="Tanggal Transaksi" />
                <x-text-input id="tanggal" name="tanggal" type="date" class="w-full" x-model="tanggalTransaksi" readonly />
            </div>

            <script>
                const produkStokMapProduct = @json($produkList->pluck('stok', 'id'));
                const produkHargaMapProduct = @json($produkList->pluck('harga', 'id'));
            </script>

            <!-- Produk List -->
            <div class="mt-4">
                <h3 class="text-md font-semibold">Daftar Produk</h3>
                <table class="w-full text-sm text-gray-500 dark:text-gray-400 mt-2">
                    <thead>
                        <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <th class="px-4 py-2">Produk</th>
                            <th class="px-4 py-2 text-center">Quantity</th>
                            <th class="px-4 py-2 text-center">Harga</th>
                            <th class="px-4 py-2 text-center">Total</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="px-4 py-2">
                                    <x-select-input
                                        name="produk[]"
                                        x-model="item.id_produk"
                                        x-on:change="
                                            item.harga = produkHargaMapTransaction[item.id_produk] || 0;
                                            item.maxStok = produkStokMapTransaction[item.id_produk] || 0;
                                            if (item.quantity > item.maxStok) item.quantity = item.maxStok;
                                        "
                                        :placeholder="'Pilih Produk'"
                                    >
                                        @foreach ($produkList as $produk)
                                            <option value="{{ $produk->id }}" @if ($produk->stok == 0) disabled @endif>
                                                {{ $produk->produk }} @if ($produk->stok == 0) (Stok Habis) @endif
                                            </option>
                                        @endforeach
                                    </x-select-input>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <x-text-input 
                                        id="quantity[]" 
                                        x-model="item.quantity" 
                                        name="quantity[]" 
                                        type="number" 
                                        class="w-full" 
                                        min="1"
                                        x-bind:max="item.maxStok" 
                                        required
                                    />
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <x-text-input x-model="item.harga" name="harga[]" type="number" class="w-full" min="0" readonly required/>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    Rp. <span class="text-gray-700 dark:text-gray-400" x-text="(item.quantity * item.harga) || 0"></span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button type="button"
                                        x-on:click="deleteItem(item.id_produk, idTransaksi, index)"
                                        class="text-red-500">
                                        Hapus
                                    </button>
                                </td>                                
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Tambah Produk -->
            <div class="mt-4">
                <button type="button" x-on:click="items.push({ id_produk: '', quantity: 1, harga: 0 })" class="bg-blue-500 text-white px-3 py-2 rounded">
                    + Tambah Produk
                </button>
            </div>
            
            <!-- Tombol Tambah Produk -->

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-info-button type="submit" x-on:click="addOrUpdateItem()" class="ms-3">
                    {{ __('Simpan') }}
                </x-info-button>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('productForm', () => ({
                        open: false,
                        items: [],
                        kodeTransaksi: '',
                        tanggalTransaksi: '',
                        
                        initializeItems() {
                            const details = {{ Js::from($transaksi->detailTransaksi ?? []) }};
                            this.items = details.map(detail => ({
                                id_produk: detail.produk.id,
                                quantity: detail.quantity,
                                harga: detail.produk.harga
                            }));
                        },
                
                        addOrUpdateItem() {
                            let selectedProduct = prompt("Masukkan ID Produk:");
                            if (!selectedProduct) return;
                
                            let foundItem = this.items.find(item => item.id_produk == selectedProduct);
                
                            if (foundItem) {
                                // Jika produk sudah ada, update quantity dan harga
                                let newQuantity = parseInt(prompt("Masukkan Quantity:", foundItem.quantity));
                                if (newQuantity > 0) {
                                    foundItem.quantity = newQuantity;
                                    foundItem.harga = produkHargaMapProduct[selectedProduct] || foundItem.harga;
                                }
                            } else {
                                // Jika produk belum ada, tambahkan ke daftar
                                this.items.push({
                                    id_produk: selectedProduct,
                                    quantity: 1,
                                    harga: produkHargaMapProduct[selectedProduct] || 0
                                });
                            }
                        }
                    }));
                });
            </script>

            <script>
                function deleteItem(id_produk, id_transaksi, index) {
                    if (!confirm('Apakah Anda yakin ingin menghapus produk ini dari transaksi?')) {
                        return;
                    }

                    console.log('Menghapus produk:', id_produk, 'dari transaksi:', id_transaksi);

                    fetch(`/transaction/${id_transaksi}/delete-product/${id_produk}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = `/transaction?success=${encodeURIComponent('Produk berhasil dihapus!')}`;
                        } else {
                            alert('Gagal menghapus produk!');
                        }
                    })
                }
            </script>    
        </form>
    </x-modal>
</section>
