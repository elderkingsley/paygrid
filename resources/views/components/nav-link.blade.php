@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-4 px-4 py-3.5 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-900/20 transition-all duration-200 group'
            : 'flex items-center gap-4 px-4 py-3.5 text-slate-400 hover:bg-slate-800/50 hover:text-white rounded-xl transition-all duration-200 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="flex-shrink-0 w-6 h-6 transition-colors duration-200 {{ ($active ?? false) ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}">
        @if($icon === 'home')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        @endif
        @if($icon === 'wallet')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        @endif
        @if($icon === 'building')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        @endif
        @if($icon === 'users')
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        @endif
    </span>
    <span class="font-medium tracking-wide text-sm">{{ $slot }}</span>
</a>
