@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center text-[13px] font-medium px-4 py-2 rounded-lg relative bg-indigo-50/60 text-indigo-600 dark:bg-indigo-950/30 dark:text-indigo-400 transition-all duration-200'
            : 'inline-flex items-center text-[13px] font-medium px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}

    @if($active ?? false)
        <span class="absolute bottom-0 left-4 right-4 h-0.5 bg-indigo-600 dark:bg-indigo-400 rounded-full"></span>
    @endif
</a>
