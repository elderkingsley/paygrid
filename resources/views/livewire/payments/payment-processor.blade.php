<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="bg-slate-900 p-8 text-white">
            <h1 class="text-2xl font-black italic tracking-tight">MAKE A PAYMENT</h1>
            <p class="text-slate-400 text-sm">Verify recipient details via Paystack Secure API</p>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase text-slate-500 mb-2">Select Bank</label>
                        <select wire:model.live="bank_code" class="w-full border-slate-200 rounded-2xl p-4 focus:ring-blue-600">
                            <option value="">Choose a bank...</option>
                            @foreach($banks as $bank)
                                <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase text-slate-500 mb-2">Account Number</label>
                        <input type="text" wire:model.live="account_number" maxlength="10" placeholder="0123456789"
                               class="w-full border-slate-200 rounded-2xl p-4 text-xl tracking-widest font-bold">
                    </div>

                    @if($account_name)
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl animate-pulse" wire:loading.remove wire:target="verifyAccount">
                        <label class="block text-[10px] font-black uppercase text-blue-400 mb-1">Account Name Found</label>
                        <div class="text-lg font-black text-blue-900">{{ $account_name }}</div>
                    </div>
                    @endif

                    <div wire:loading wire:target="verifyAccount" class="text-blue-600 font-bold italic animate-bounce">
                        Verifying recipient...
                    </div>
                </div>

                <div class="bg-slate-50 p-6 rounded-3xl border border-dashed border-slate-300">
                    <h3 class="font-bold text-slate-800 mb-4">Post-Payment Actions</h3>

                    <div class="flex items-center gap-3 mb-6">
                        <input type="checkbox" wire:model.live="save_as_vendor" id="saveVendor" class="rounded text-blue-600">
                        <label for="saveVendor" class="text-sm font-bold text-slate-700 pointer-events-none">Save as regular Vendor?</label>
                    </div>

                    @if($save_as_vendor)
                    <div class="space-y-4">
                        <label class="block text-xs font-black uppercase text-slate-500 mb-1">Display Name</label>
                        <input type="text" wire:model="vendor_name" class="w-full border-slate-200 rounded-xl p-3 bg-white">
                        <p class="text-[10px] text-slate-400">This is how they will appear in your vendor list.</p>
                    </div>
                    @endif

                    <button wire:click="processPayment"
                        class="w-full mt-8 bg-blue-600 text-white py-4 rounded-2xl font-black text-lg shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">
                        CONFIRM & CONTINUE
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
