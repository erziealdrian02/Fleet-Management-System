@props(['title', 'icon' => null, 'defaultOpen' => true])

<div x-data="{ open: {{ $defaultOpen ? 'true' : 'false' }} }">
    <!-- Trigger -->
    <div @click="open = !open" class="flex items-center justify-between w-full px-6 py-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 transition-all duration-200 ease-in-out cursor-pointer">
        <div class="flex items-center">
            @if ($icon)
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $icon !!}
                </svg>
            @endif
            <span>{{ $title }}</span>
        </div>
        <svg class="w-5 h-5 transform transition-transform duration-200 ease-in-out" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>

    <!-- Dropdown Content -->
    <div x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="ml-6 overflow-hidden"
    >
        <div class="py-2">
            {{ $slot }}
        </div>
    </div>
</div>
