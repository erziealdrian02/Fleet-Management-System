<!-- resources/views/vehicles/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vehicle Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 mb-4">
                <span>Vehicle Document</span>
                <span>›</span>
                <span>List</span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8">Vehicle Document</h1>

            <!-- Main Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow" x-data="{
                isEdit: false,
                documentVehicleID: '', 
                documentType: '',
                documentIssueDate: '',
                documentExpiryDate: '',
                documentFile: null,  // Change to null initially
                documentId: '',
                existingDocumentFile: '', // Add this to store the existing file path/url

                initEdit(document) {
                    this.isEdit = true;
                    this.documentVehicleID = document.vehicle_id;
                    this.documentType = document.document_type;
                    this.documentIssueDate = document.issue_date;
                    this.documentExpiryDate = document.expiry_date;
                    this.existingDocumentFile = document.document_file; // Store the existing file path
                    this.documentId = document.id;
                    this.$dispatch('open-modal', 'document-modal');
                    
                    // If you want to show the existing file preview
                    if (this.existingDocumentFile) {
                        const previewContainer = document.getElementById('preview-container');
                        const previewImage = document.getElementById('preview-image');
                        const previewPDF = document.getElementById('preview-pdf');
                        
                        if (this.existingDocumentFile.endsWith('.pdf')) {
                            previewImage.classList.add('hidden');
                            previewPDF.classList.remove('hidden');
                        } else {
                            previewImage.src = this.existingDocumentFile;
                            previewImage.classList.remove('hidden');
                            previewPDF.classList.add('hidden');
                        }
                        previewContainer.classList.remove('hidden');
                    }
                }
            }">
                <!-- Header Actions -->
                <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-4">
                        @include('formVehicleDocument.add-addVehicleDocument-form')
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    License Plate
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    Vehicle Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    Document Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    Issue Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    Expired Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    Document
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase document-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($documentList as $documents)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $documents->vehicle->license_plate }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $documents->vehicle->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $documents->document_type }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $documents->issue_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $documents->expiry_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <x-link-button-info class="mt-4" href="{{ $documents->document_file }}" _blank>
                                            {{ __('See Document') }}
                                        </x-link-button-info>
                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <x-warning-button x-on:click="initEdit({{ $documents }})">
                                            <x-heroicon-o-pencil-square class="w-4 h-4"/>
                                        </x-warning-button>                                        

                                        <x-danger-button onclick="confirmDelete({{ $documents->id }})">  
                                            <x-heroicon-o-trash class="w-4 h-4"/>
                                        </x-danger-button>  

                                        <form id="delete-form-{{ $documents->id }}" action="{{ route('document.delete', $documents->id) }}" method="POST" style="display: none;">  
                                            @csrf  
                                            @method('DELETE')  
                                        </form>  
                                    </td>
                                </tr>
                            @empty  
                                <tr class="bg-white border-b dark:bg-gray-800 text-gray-800 dark:text-white">
                                    <td colspan="8" class="px-6 py-4 text-center">Tidak ada data transaksi.</td>  
                                </tr>  
                            @endforelse 
                        </tbody>
                    </table>
                </div>

                @include('formVehicleDocument.edit-editVehicleDocument-form')

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
        function confirmDelete(documentId) {
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {  
                document.getElementById('delete-form-' + documentId).submit();  
            }  
        }  
    </script>
</x-app-layout>