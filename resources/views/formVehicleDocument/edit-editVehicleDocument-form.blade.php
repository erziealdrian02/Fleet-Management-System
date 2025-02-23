<x-modal name="document-modal" focusable maxWidth="4xl">
    <form x-bind:action="isEdit 
        ? '{{ route('document.update', '') }}/' + documentId 
        : '{{ route('document.store') }}'" 
        method="POST" 
        class="p-6"
    >
        @csrf
        <template x-if="isEdit">
            @method('PUT')
        </template>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Vehicle Document') }}
            </h2>
            <button type="button" x-on:click="$dispatch('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Assigned Vehicle -->
            <div>
                <x-input-label for="vehicle_id" :value="__('Vehicle')" required />
                <select 
                    id="vehicle_id" 
                    name="vehicle_id" 
                    class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white focus:border-orange-500 focus:ring-orange-500"
                    x-model="documentVehicleID"
                >
                    <option value="" disabled selected>No Vehicle</option>
                    @foreach ($vehiclesList as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} - {{ $vehicle->type }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Document Type -->
            <div>
                <x-input-label for="document_type" :value="__('Document Type')" required />
                <select 
                    id="document_type" 
                    name="document_type" 
                    class="mt-1 block w-full rounded-md bg-gray-800 border-gray-700 text-white focus:border-orange-500 focus:ring-orange-500"
                    required
                    x-model="documentType"
                >
                    <option value="">Select Type</option>
                    @foreach(['STNK', 'KIR', 'Asuransi'] as $type)
                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
    
            <!-- Issue Date -->
            <div>
                <x-input-label for="issue_date" :value="__('Issue Date')" required />
                <x-text-input 
                    id="issue_date" 
                    name="issue_date" 
                    type="date" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="documentIssueDate"
                />
            </div>
    
            <!-- Expiry Date -->
            <div>
                <x-input-label for="expiry_date" :value="__('Expiry Date')" required />
                <x-text-input 
                    id="expiry_date" 
                    name="expiry_date" 
                    type="date" 
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white" 
                    required 
                    x-model="documentExpiryDate"
                />
            </div>
    
            <!-- Upload Document -->
            <div>
                <x-input-label for="document_file" :value="__('Upload Document (Image)')" required />
                <input 
                    id="document_file" 
                    name="document_file" 
                    type="file" 
                    accept="image/*,application/pdf" 
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" 
                    aria-describedby="file_input_help"
                    @change="documentFile = $event.target.files[0]"
                    onchange="previewFile(event)"
                />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG, JPEG or PDF (MAX. 2mb).</p>

                <div id="preview-container" class="mt-3 hidden">
                    <img id="preview-image" src="" alt="Preview" class="max-h-40 border rounded-lg hidden">
                    <img id="preview-pdf" src="https://img.icons8.com/color/48/000000/pdf.png" alt="PDF Preview" class="hidden">
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

    <script>
        function previewFile(event) {
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const previewPDF = document.getElementById('preview-pdf');
            const file = event.target.files[0];
    
            if (file) {
                const fileType = file.type;
                const reader = new FileReader();
    
                if (fileType.includes('image')) {
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        previewPDF.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else if (fileType === 'application/pdf') {
                    previewImage.classList.add('hidden');
                    previewPDF.classList.remove('hidden');
                }
    
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script> 
</x-modal>