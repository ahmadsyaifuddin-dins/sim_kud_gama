@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'group relative flex items-center mt-2 mb-1 mx-3 px-4 py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-fuchsia-500 text-white font-semibold shadow-lg shadow-pink-900/40 ring-1 ring-white/25'
                : 'group relative flex items-center mt-2 mb-1 mx-3 px-4 py-2.5 rounded-xl text-pink-100/80 transition-all duration-200 ease-out hover:text-white hover:bg-white/10 hover:shadow-md hover:shadow-pink-900/20 hover:translate-x-0.5';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if ($active ?? false)
        <span class="absolute left-2 top-1/2 -translate-y-1/2 h-1.5 w-1.5 rounded-full bg-white shadow-[0_0_10px_2px_rgba(255,255,255,0.9)]"></span>
    @endif
    {{ $icon ?? '' }}
    <span class="mx-3">{{ $slot }}</span>
</a>
