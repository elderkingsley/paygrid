<div class="p-8 relative" wire:ignore.self>
    {{-- This overlay only appears when the 'save' function is running --}}
    <div wire:loading wire:target="save" class="absolute inset-0 z-50 bg-white/60 backdrop-blur-[2px] rounded-[3rem] flex flex-col items-center justify-center transition-all">
        <div class="relative flex items-center justify-center">
            {{-- Modern Spinner --}}
            <div class="w-12 h-12 border-4 border-slate-200 border-t-blue-600 rounded-full animate-spin"></div>
            {{-- Pulsing Logo or Icon in middle --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
            </div>
        </div>
        <p class="mt-4 text-[10px] font-black uppercase tracking-[0.2em] text-slate-600">Encrypting & Sending Invite...</p>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Invite Team Member</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">New User Authorization</p>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        {{-- Row 1: First & Last Name --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2 ml-1">First Name</label>
                <input type="text" wire:model="first_name" placeholder="John"
                    class="w-full bg-slate-50 border-slate-100 text-slate-800 rounded-2xl focus:ring-blue-500 focus:border-blue-500 text-sm p-4 transition-all">
                @error('first_name') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2 ml-1">Last Name</label>
                <input type="text" wire:model="last_name" placeholder="Doe"
                    class="w-full bg-slate-50 border-slate-100 text-slate-800 rounded-2xl focus:ring-blue-500 focus:border-blue-500 text-sm p-4 transition-all">
                @error('last_name') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Row 2: Email --}}
        <div>
            <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2 ml-1">Email Address</label>
            <input type="email" wire:model="email" placeholder="staff@company.com"
                class="w-full bg-slate-50 border-slate-100 text-slate-800 rounded-2xl focus:ring-blue-500 focus:border-blue-500 text-sm p-4 transition-all">
            @error('email') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span> @enderror
        </div>

        {{-- Row 3: Org & Role --}}
        <div class="grid grid-cols-2 gap-4">
            {{-- Replace the previous Row 3 (Org & Role) with just this Role input --}}
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-tighter mb-2 ml-1">Assign System Role</label>
                    <select wire:model="role"
                        class="w-full bg-slate-50 border-slate-100 text-slate-800 rounded-2xl focus:ring-blue-500 focus:border-blue-500 text-sm p-4 font-bold transition-all">
                        <option value="">-- Select User Role --</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</span> @enderror

                    <p class="mt-3 text-[9px] text-slate-400 px-1 italic">
                        * The user will be automatically added to <strong>{{ auth()->user()->organization->name }}</strong>
                    </p>
                </div>
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="w-full bg-slate-900 hover:bg-blue-600 text-white p-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3">
            <span wire:loading.remove wire:target="save">Send Invitation Email</span>
            <span wire:loading wire:target="save">Dispatching...</span>
        </button>
    </form>
</div>
