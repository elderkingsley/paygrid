<div x-data="{ open: @entangle('showModal') }"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[100] overflow-y-auto">

    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-xl bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-100">

            <div class="bg-slate-50 px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-black text-slate-900 italic tracking-tight">NEW PAYMENT REQUEST</h2>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Finance Operations</p>
                </div>
                <button @click="open = false" class="h-10 w-10 flex items-center justify-center rounded-full hover:bg-slate-200 transition text-slate-400">&times;</button>
            </div>

            <div class="p-8 space-y-5">
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-100 rounded-2xl">
                        <p class="text-[10px] font-black text-red-600 uppercase mb-2">Submission Errors:</p>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-xs text-red-500 font-bold">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Payment Category</label>
                        <select wire:model.live="category_id" class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm focus:ring-blue-600">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Amount (NGN)</label>
    <div x-data="{
        displayAmount: '',
        formatAmount(val) {
            if (!val) return '';
            // Remove everything except numbers and one dot
            let clean = val.replace(/[^\d.]/g, '');
            let parts = clean.split('.');
            // Add commas to the thousands
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            // Join back with decimal if it exists
            return parts.length > 1 ? parts[0] + '.' + parts[1].substring(0, 2) : parts[0];
        },
        updateLivewire(val) {
            // Remove commas before sending to Livewire so it stays a numeric string
            let numeric = val.replace(/,/g, '');
            @this.set('amount', numeric);
        }
    }">
        <input type="text"
               x-model="displayAmount"
               @input="displayAmount = formatAmount($event.target.value); updateLivewire(displayAmount)"
               placeholder="0.00"
               class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm font-bold focus:ring-blue-600 focus:border-blue-600"
        >
    </div>
</div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Request Details</label>
                    <textarea wire:model="details" rows="2" placeholder="What is this payment for?" class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm"></textarea>
                </div>

                <div class="p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <select wire:model.live="bank_code" class="border-slate-200 rounded-xl p-2 text-xs bg-white">
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank) <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option> @endforeach
                        </select>
                        <input type="text"
                                wire:model.live="account_number"
                                maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Account Number"
                                class="border-slate-200 rounded-xl p-2 text-xs bg-white">
                    </div>

                    @if($account_error)
                        <div class="text-[10px] font-bold text-red-500 bg-red-50 p-2 rounded-lg border border-red-100 italic">{{ $account_error }}</div>
                    @endif

                    @if($is_verifying)
                        <div class="text-[10px] font-bold text-blue-600 animate-pulse flex items-center gap-2">
                             <div class="w-2 h-2 bg-blue-600 rounded-full animate-ping"></div>
                             Verifying Account...
                        </div>
                    @elseif($account_name)
                        <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-slate-100">
                            <div class="text-xs font-black text-slate-900 uppercase">{{ $account_name }}</div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" wire:model="save_as_vendor" id="saveV" class="rounded text-blue-600">
                                <label for="saveV" class="text-[10px] font-black text-slate-500 uppercase cursor-pointer">Save Vendor</label>
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Supporting Document</label>
                    <input type="file" wire:model="receipt" class="w-full mt-1 text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700">
                    <div wire:loading wire:target="receipt" class="text-[10px] font-bold text-blue-600 mt-1 uppercase">Uploading file...</div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button @click="open = false" type="button" class="flex-1 py-4 text-sm font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition">Cancel</button>

                    <button wire:click="submitRequest"
                            wire:loading.attr="disabled"
                            class="flex-[2] bg-blue-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-blue-200 hover:bg-blue-700 transition active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="submitRequest">SUBMIT REQUEST</span>
                        <span wire:loading wire:target="submitRequest" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            PROCESSING...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('swal:modal', event => {
        // Livewire 3 event data is found inside event.detail[0]
        const data = event.detail[0];

        Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.type,
            confirmButtonColor: '#2563eb'
        });
    });
</script>
