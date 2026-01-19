<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Paygrid') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>[x-cloak] { display: none !important; }</style>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ mobileMenuOpen: false }">

    <div x-show="mobileMenuOpen" class="fixed inset-0 z-50 flex lg:hidden" x-cloak role="dialog" aria-modal="true">
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex w-full max-w-xs flex-1 flex-col bg-slate-900 pt-5 pb-4 shadow-2xl">

            <div class="flex items-center justify-between px-6 mb-8">
                <span class="text-white text-2xl font-black italic tracking-tighter">PAYGRID</span>
                <button @click="mobileMenuOpen = false" class="text-slate-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-8 overflow-y-auto">
                @include('layouts.navigation-content')

                <div class="mt-8 px-2">
                    <button @click="$dispatch('openExpenseModal')" class="w-full bg-blue-600 text-white font-black py-4 rounded-2xl shadow-xl active:scale-95 transition">
                        + NEW EXPENSE
                    </button>
                </div>
            </nav>
        </div>
    </div>

    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-72 lg:flex-col lg:bg-slate-900 border-r border-slate-800">
        <div class="flex h-20 items-center px-8 border-b border-slate-800/50">
            <span class="text-white text-2xl font-black italic tracking-tighter">PAYGRID</span>
        </div>

        <nav class="flex-1 px-4 space-y-8 overflow-y-auto pt-8">
            @include('layouts.navigation-content')
        </nav>

    </div>

    <div class="flex flex-col lg:pl-72 h-screen overflow-hidden">
        <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white/80 backdrop-blur-md px-4 shadow-sm sm:px-6 lg:px-8">
            <button @click="mobileMenuOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>

            <div class="flex flex-1 justify-end items-center gap-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] font-bold text-blue-600 uppercase tracking-tight mt-1">
                        {{ Auth::user()->organization->name ?? 'Personal Account' }}
                    </div>
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 flex items-center justify-center text-white font-black text-sm shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 bg-slate-50">
            {{ $slot }}
        </main>
    </div>

    <livewire:expenses.master-expense-modal />
    @livewire('expenses.create-category-modal')

    @livewireScripts
</body>
</html>
