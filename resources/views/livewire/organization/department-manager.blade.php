<div class="max-w-6xl mx-auto py-10 px-4">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-900 italic tracking-tight">DEPARTMENTAL WALLETS</h1>
            <p class="text-sm text-slate-500">Manage segregated funding for your organizational units.</p>
        </div>

        <div class="flex gap-2">
            <input type="text" wire:model="name" placeholder="New Dept Name" class="border-slate-200 rounded-xl text-sm px-4">
            <button wire:click="createDepartment" class="bg-blue-600 text-white px-6 py-2 rounded-xl text-xs font-black uppercase">Add Dept</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($departments as $dept)
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="font-black text-slate-800 uppercase tracking-tight">{{ $dept->name }}</h3>
                    <span class="text-[10px] px-2 py-1 rounded bg-slate-100 font-bold text-slate-500 uppercase">Sub-Account</span>
                </div>

                @if($dept->virtual_account_number)
                    <div class="bg-slate-50 p-4 rounded-2xl mb-4 border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Account Number</p>
                        <p class="text-xl font-mono font-bold text-slate-900 tracking-tighter">{{ $dept->virtual_account_number }}</p>
                        <p class="text-[10px] text-blue-600 font-black mt-2">WEMA BANK</p>
                    </div>
                    <div class="text-[10px] text-slate-400 italic">Name: {{ $dept->virtual_account_name }}</div>
                @else
                    <div class="py-8 text-center border-2 border-dashed border-slate-100 rounded-2xl mb-4">
                        <p class="text-xs text-slate-400 mb-4">No virtual account assigned yet.</p>
                        <button wire:click="generateDepartmentWallet({{ $dept->id }})"
                                wire:loading.attr="disabled"
                                class="bg-slate-900 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase">
                            Generate Wallet
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
