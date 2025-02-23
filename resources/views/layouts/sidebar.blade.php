<!-- layouts/sidebar.blade.php -->
<div x-data="{ sidebarOpen: false }" class="relative">
    <div 
        x-cloak
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed inset-y-0 left-0 z-30 w-64 h-full overflow-y-auto hidden lg:block transition duration-300 transform bg-white dark:bg-gray-800 lg:translate-x-0 lg:static lg:inset-0 border-r dark:border-gray-700">
        
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center mt-8">
            <div class="flex items-center">
                <span class="text-2xl font-semibold text-gray-800 dark:text-white">Dashboard</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mt-10">
            <!-- Dashboard -->
            <x-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <x-heroicon-o-chart-pie class="w-6 h-6"/>
                <span class="mx-3">Dashboard</span>
            </x-link-sidebar>

            <x-link-sidebar href="{{ route('company') }}" :active="request()->routeIs('company')">
                <x-heroicon-s-building-office-2 class="w-6 h-6"/>
                <span class="mx-3">Company List</span>
            </x-link-sidebar>
        
            <!-- Manajemen Kendaraan -->
            <x-dropdown-sidebar title="Manajemen Kendaraan">
                <x-link-sidebar href="{{ route('vehicle') }}" :active="request()->routeIs('vehicle')">
                    <x-heroicon-o-truck class="w-5 h-5 mr-2"/>
                    <span>Vehicle</span>
                </x-link-sidebar>
                <x-link-sidebar href="{{ route('driver') }}" :active="request()->routeIs('driver')">
                    <x-heroicon-o-users class="w-5 h-5 mr-2" />
                    <span>Drivers</span>
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
                    <x-heroicon-o-map-pin class="w-5 h-5 mr-2" />
                    <span>GPS Trackings</span>
                </x-link-sidebar>
                <x-link-sidebar href="{{ route('document') }}" :active="request()->routeIs('document')">
                    <x-heroicon-c-document-duplicate class="w-5 h-5 mr-2" />
                    <span>Legal Document</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>
        
            <!-- Manajemen Perjalanan -->
            <x-dropdown-sidebar title="Manajemen Perjalanan">
                {{-- <x-link-sidebar>
                    <x-heroicon-o-map class="w-5 h-5 mr-2" />
                    <span>Routes</span>
                </x-link-sidebar> --}}
                <x-link-sidebar href="{{ route('trips') }}" :active="request()->routeIs('trips')">
                    <x-heroicon-o-rectangle-group class="w-5 h-5 mr-2" />
                    <span>Trips</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>

            <x-dropdown-sidebar title="Improvement Driver">
                {{-- <x-link-sidebar>
                    <x-heroicon-o-map class="w-5 h-5 mr-2" />
                    <span>Routes</span>
                </x-link-sidebar> --}}
                <x-link-sidebar href="{{ route('question') }}" :active="request()->routeIs('question')">
                    <x-heroicon-c-question-mark-circle class="w-5 h-5 mr-2" />
                    <span>Question</span>
                </x-link-sidebar>
            </x-dropdown-sidebar>
        
            <!-- Keamanan & Insiden -->
            {{-- <x-dropdown-sidebar title="Keamanan & Insiden">
                <x-link-sidebar>
                    <x-heroicon-o-exclamation-circle class="w-5 h-5 mr-2" />
                    <span>Accident</span>
                </x-link-sidebar>
                <x-link-sidebar>
                    <x-heroicon-o-bell class="w-5 h-5 mr-2" />
                    <span>Alert</span>
                </x-link-sidebar>
            </x-dropdown-sidebar> --}}
        </nav>        
    </div>
</div>