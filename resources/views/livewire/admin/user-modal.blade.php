{{-- Ensure x-on:close-user-modal matches exactly what is in the PHP dispatch --}}
<div x-data="{ show: false }"
     x-on:open-user-modal.window="show = true"
     x-on:close-user-modal.window="show = false" {{-- This listens for the dispatch --}}
     x-show="show"
     class="fixed inset-0 z-[60] overflow-y-auto"
     x-cloak>

    {{-- Backdrop --}}
    <div x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-md"></div>

    {{-- Modal Content --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             @click.away="show = false"
             class="relative bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100">

            {{-- Form Content --}}
            @livewire('admin.create-user')

        </div>
    </div>
</div>
