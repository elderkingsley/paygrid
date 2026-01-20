<div class="max-w-4xl mx-auto py-10">

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">TREASURY SETTINGS</h1>
        <p class="text-sm text-slate-500">Manage your organization's funding sources and KYC.</p>
    </div>

    @if($organization->virtual_account_number)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative h-56 bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl shadow-2xl p-8 overflow-hidden">
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Main Wallet</p>
                            <h3 class="text-white font-black text-lg tracking-wide">{{ $organization->name }}</h3>
                        </div>
                        <div class="h-8 w-12 bg-white/10 rounded flex items-center justify-center">
                            <span class="text-[10px] text-white font-bold">NGN</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="text-3xl text-white font-mono tracking-widest">{{ chunk_split($organization->virtual_account_number, 4, ' ') }}</p>
                        <p class="text-xs text-blue-200 font-bold uppercase tracking-widest">{{ $organization->virtual_bank_name }}</p>
                    </div>

                    <div class="flex justify-between items-end">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                            <span class="text-[10px] text-green-400 font-bold uppercase">Active</span>
                        </div>
                        <p class="text-[10px] text-slate-500 uppercase">Powered by Paystack</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 space-y-4">
                <h3 class="font-black text-slate-900">How to fund this wallet</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Make a standard bank transfer to the account details displayed on the card. Funds will automatically reflect in your organization's dashboard balance.
                </p>
                <div class="pt-4 border-t border-slate-100">
                    <button class="text-blue-600 text-xs font-black uppercase hover:underline">Download Account Certificate &rarr;</button>
                </div>
            </div>
        </div>

    @else
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
            <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-12">

                <div class="space-y-6">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900">Activate your Dedicated Account</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        To generate a dedicated NUBAN account number for your organization, we require your business registration details.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                            Instant account generation
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                            Zero maintenance fees
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                            Dept. sub-accounts enabled
                        </li>
                    </ul>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Company Name</label>
                        <input type="text" wire:model="org_name" readonly class="w-full mt-1 bg-slate-50 border-slate-200 text-slate-500 rounded-2xl p-3 text-sm font-bold cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                        <input type="text" wire:model="phone" placeholder="e.g. 08012345678" class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm font-bold focus:ring-blue-600">
                        @error('phone') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">CAC Registration No.</label>
                        <input type="text" wire:model="cac_number" placeholder="RC-123456" class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm font-bold focus:ring-blue-600">
                        @error('cac_number') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tax ID (TIN)</label>
                        <input type="text" wire:model="tin_number" placeholder="12345678-0001" class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm font-bold focus:ring-blue-600">
                        @error('tin_number') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <button wire:click="generateAccount"
                            wire:loading.attr="disabled"
                            class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black shadow-xl shadow-slate-200 hover:bg-slate-800 transition active:scale-95 disabled:opacity-75">
                        <span wire:loading.remove wire:target="generateAccount">ACTIVATE ACCOUNT</span>
                        <span wire:loading wire:target="generateAccount">VERIFYING WITH PROVIDER...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
