@props(['active' => false, 'href' => '#'])

@php
$classes = $active 
    ? 'flex items-center px-6 py-2 text-gray-900 dark:text-white bg-gray-200 dark:bg-gray-800 transition-all duration-200 ease-in-out border-b-2 border-blue-500'
    : 'flex items-center px-6 py-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes, 'href' => $href]) }}>
    {{ $slot }}
</a>
