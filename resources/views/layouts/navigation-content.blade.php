{{-- Core Section --}}
{{-- Main Menu Section --}}
<div>
    <p class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Core Application</p>
    <div class="space-y-2">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">
            Dashboard
        </x-nav-link>

        {{-- Requests are usually for Requesters or Admins --}}
        @role(['requester', 'admin'])
            <button @click="$dispatch('openExpenseModal')"
                class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold transition-all rounded-xl text-slate-400 hover:text-white hover:bg-white/5 group">
                <div class="p-2 rounded-lg bg-slate-800 group-hover:bg-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span>New Request</span>
            </button>
        @endrole

        {{-- Visible to Approvers or Admins --}}
        @role(['approver', 'admin'])
            <x-nav-link href="{{ route('requests.index') }}" :active="request()->routeIs('requests.index')" icon="building">
                Pending Approvals
            </x-nav-link>
        @endrole

        <x-nav-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.index')" icon="wallet">
            Payments History
        </x-nav-link>
    </div>
</div>

{{-- Admin Section --}}
@role('admin')
    <div class="pt-8">
        <p class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Administration</p>
        <div class="space-y-2">
            <x-nav-link href="{{ route('departments.index') }}" :active="request()->routeIs('departments.index')" icon="building">
                Departments
            </x-nav-link>

            <x-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.index')" icon="wallet">
                Expense Categories
            </x-nav-link>

            <x-nav-link href="{{ route('vendors.index') }}" :active="request()->routeIs('vendors.index')" icon="users">
                Vendors
            </x-nav-link>

            {{-- Team Management Section with Embedded Component --}}
            {{-- Replace the previous Team Management block with this --}}
            @role('admin')
                <div class="pt-4">
                    <p class="px-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-4">Administration</p>
                    <div class="space-y-2">
                        {{-- Existing links (Departments, Vendors, etc.) --}}

                        <button type="button"
                            @click="$dispatch('open-user-modal')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold transition-all rounded-xl text-slate-400 hover:text-white hover:bg-white/5 group">
                            <div class="p-2 rounded-lg bg-slate-800 group-hover:bg-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                            <span>Team Management</span>
                        </button>
                    </div>
                </div>
            @endrole
        </div>

        <a href="{{ route('settings.treasury') }}"
            wire:navigate
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold transition-all rounded-xl text-slate-400 hover:text-white hover:bg-white/5 group mt-2">
            <div class="p-2 rounded-lg bg-slate-800 group-hover:bg-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <span>Treasury Settings</span>
        </a>
    </div>
@endrole
