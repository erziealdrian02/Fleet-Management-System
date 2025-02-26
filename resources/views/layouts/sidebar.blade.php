<!-- layouts/sidebar.blade.php -->
<div x-data="{ sidebarOpen: false }" class="relative">
    <div 
        x-cloak
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed inset-y-0 left-0 z-30 w-64 h-full overflow-y-auto hidden lg:block transition duration-300 transform bg-white dark:bg-gray-800 lg:translate-x-0 lg:static lg:inset-0 border-r dark:border-gray-700">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center mt-8">
            <div class="flex items-center">
                <span class="text-xl font-semibold text-center text-gray-800 dark:text-white">COAL HAULING COMPANY</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-10">
            <!-- Dashboard & Company -->
            <x-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <x-heroicon-o-chart-pie class="w-6 h-6"/>
                <span class="mx-3">Dashboard</span>
            </x-link-sidebar>

            <x-link-sidebar href="{{ route('company') }}" :active="request()->routeIs('company')">
                <x-heroicon-s-building-office-2 class="w-6 h-6"/>
                <span class="mx-3">Company List</span>
            </x-link-sidebar>

            <!-- Vehicle Management -->
            <x-dropdown-sidebar title="Vehicle Management">
                <x-link-sidebar href="{{ route('vehicle') }}" :active="request()->routeIs('vehicle')">
                    <x-heroicon-o-truck class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Vehicles</span>
                </x-link-sidebar>
                
                <x-link-sidebar href="{{ route('driver') }}" :active="request()->routeIs('driver')">
                    <x-heroicon-o-users class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Drivers</span>
                </x-link-sidebar>

                {{-- <x-link-sidebar>
                    <x-heroicon-o-wrench class="w-5 h-5 mr-2" />
                    <span>Maintenances</span>
                </x-link-sidebar>
                <x-link-sidebar>
                    <x-heroicon-c-newspaper class="w-5 h-5 mr-2" />
                    <span>Fuel Usages</span>
                </x-link-sidebar> --}}

                <x-link-sidebar href="{{ route('tracking') }}" :active="request()->routeIs('tracking')">
                    <x-heroicon-o-map-pin class="w-5 h-5 mr-2"/>
                    <span class="mx-3">GPS Tracking</span>
                </x-link-sidebar>
                
                <x-link-sidebar href="{{ route('document') }}" :active="request()->routeIs('document')">
                    <x-heroicon-c-document-duplicate class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Legal Documents</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>

            <!-- Spare Part Management -->
            <x-dropdown-sidebar title="Spare Part Management">
                <x-link-sidebar href="{{ route('spareparts') }}" :active="request()->routeIs('spareparts')">
                    <x-heroicon-s-wrench class="w-6 h-6"/>
                    <span class="mx-3">Stock Spare Parts</span>
                </x-link-sidebar>
                
                <x-link-sidebar href="{{ route('requestPart') }}" :active="request()->routeIs('requestPart')">
                    <x-heroicon-s-clipboard-document-list class="w-6 h-6"/>
                    <span class="mx-3">Request Spare Parts</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>

            <!-- Trip Management -->
            <x-dropdown-sidebar title="Trip Management">
                <x-link-sidebar href="{{ route('trips') }}" :active="request()->routeIs('trips')">
                    <x-heroicon-o-rectangle-group class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Trips</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>

            <!-- Driver Improvement -->
            <x-dropdown-sidebar title="Driver Improvement"  :defaultOpen="false">
                <x-link-sidebar href="{{ route('question') }}" :active="request()->routeIs('question')">
                    <x-heroicon-c-question-mark-circle class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Training Questions</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>

            <!-- Security & Incidents -->
            {{-- <x-dropdown-sidebar title="Security & Incidents">
                <x-link-sidebar href="#">
                    <x-heroicon-o-exclamation-circle class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Accidents</span>
                </x-link-sidebar>
                
                <x-link-sidebar href="#">
                    <x-heroicon-o-bell class="w-5 h-5 mr-2"/>
                    <span class="mx-3">Alerts</span>
                </x-link-sidebar>
            </x-dropdown-sidebar> --}}
        </nav>        
    </div>
</div>