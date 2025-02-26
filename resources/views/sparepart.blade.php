<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <span>{{ $title }}</span>
                <span>›</span>
                <span>List</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8">{{ $title }}</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow" 
                x-data="sparePartsHandler()">
                
                <!-- Header Actions -->
                <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4">
                        @include('formSpareparts.add-addSparepart-form')
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
                            <input type="text" x-model="searchQuery" @input="performSearch()" placeholder="Search"
                                class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-orange-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Part Number
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="(sparepart, index) in paginatedSpareparts" :key="sparepart.id">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="((currentPage - 1) * itemsPerPage) + index + 1"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="sparepart.name"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="sparepart.part_number"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="sparepart.stock_quantity"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="sparepart.price"></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <x-warning-button @click="initEdit(sparepart)">
                                            <x-heroicon-o-pencil-square class="w-4 h-4"/>
                                        </x-warning-button>                                        

                                        <x-danger-button @click="confirmDelete(sparepart.id)">  
                                            <x-heroicon-o-trash class="w-4 h-4"/>
                                        </x-danger-button>  

                                        <form :id="'delete-form-' + sparepart.id" :action="'/spareparts/delete/' + sparepart.id" method="POST" style="display: none;">  
                                            @csrf  
                                            @method('DELETE')  
                                        </form>  
                                    </td>
                                </tr>
                            </template>
                            
                            <tr x-show="paginatedSpareparts.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data spare parts.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @include('formSpareparts.edit-editSparepart-form')

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4 sm:mb-0">
                            Showing <span x-text="((currentPage - 1) * itemsPerPage) + 1"></span>
                            to <span x-text="Math.min(currentPage * itemsPerPage, filteredSpareparts.length)"></span>
                            of <span x-text="filteredSpareparts.length"></span> results
                        </div>
                        
                        <div class="flex items-center">
                            <div class="flex items-center space-x-2 mr-4">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Per page</span>
                                <select @change="setItemsPerPage($event.target.value)" 
                                    class="rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <button @click="prevPage()" :disabled="currentPage === 1" 
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600" 
                                    :class="{'opacity-50 cursor-not-allowed': currentPage === 1}">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <template x-for="page in totalPages" :key="page">
                                    <button @click="goToPage(page)" 
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-600"
                                        :class="currentPage === page ? 'bg-orange-50 dark:bg-orange-900 text-orange-600 dark:text-orange-300 border-orange-500' : 'text-gray-700 dark:text-gray-300'">
                                        <span x-text="page"></span>
                                    </button>
                                </template>
                                
                                <button @click="nextPage()" :disabled="currentPage === totalPages" 
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    :class="{'opacity-50 cursor-not-allowed': currentPage === totalPages}">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script for Alpine Component --}}
    <script>
        function sparePartsHandler() {
            return {
                allSpareparts: @json($spareList instanceof \Illuminate\Pagination\LengthAwarePaginator ? $spareList->items() : $spareList),
                isEdit: false,
                searchQuery: '',
                currentPage: 1,
                itemsPerPage: 10,
                
                // Edit data
                spareId: '',
                spareName: '',
                sparePartNumber: '',
                spareStock: '',
                sparePrice: '',
                
                // Computed properties
                get filteredSpareparts() {
                    if (!this.searchQuery) return this.allSpareparts;
                    
                    const query = this.searchQuery.toLowerCase();
                    return this.allSpareparts.filter(item => {
                        return item.name.toLowerCase().includes(query) || 
                            item.part_number.toLowerCase().includes(query);
                    });
                },
                
                get totalPages() {
                    return Math.ceil(this.filteredSpareparts.length / this.itemsPerPage);
                },
                
                get paginatedSpareparts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredSpareparts.slice(start, end);
                },
                
                // Methods
                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },
                
                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },
                
                goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },
                
                setItemsPerPage(value) {
                    this.itemsPerPage = parseInt(value);
                    this.currentPage = 1; // Reset to first page when changing items per page
                },
                
                initEdit(spare) {
                    this.isEdit = true;
                    this.spareId = spare.id;
                    this.spareName = spare.name;
                    this.sparePartNumber = spare.part_number;
                    this.spareStock = spare.stock_quantity;
                    this.sparePrice = spare.price;
                    this.$dispatch('open-modal', 'sparepart-modal');
                },
                
                performSearch() {
                    this.currentPage = 1; // Reset to first page on new search
                },
                
                confirmDelete(id) {
                    if (confirm('Apakah Anda yakin ingin menghapus spare part ini?')) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                }
            }
        }
    </script>
</x-app-layout>