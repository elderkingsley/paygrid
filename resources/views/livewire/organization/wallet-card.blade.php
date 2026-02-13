<div wire:poll.10s class="space-y-6">
    <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-1">
                <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest">Available Balance</h3>
                <div wire:loading.delay>
                    <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <div class="text-4xl font-black mb-6">
                ₦{{ number_format($balance, 2) }}
            </div>

            <div class="flex justify-between items-end border-t border-slate-800 pt-6">
                <div>
                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter">Virtual Account</p>
                    <p class="text-sm font-medium tracking-tight text-slate-200">{{ $accountNumber }}</p>
                    <p class="text-[10px] text-blue-400 font-bold">{{ $bankName }}</p>
                </div>

                <div class="bg-green-500/10 text-green-400 text-[10px] px-2 py-1 rounded-full flex items-center gap-1">
                    <div class="w-1 h-1 bg-green-400 rounded-full animate-pulse"></div>
                    LIVE LEDGER
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/20 rounded-full blur-3xl"></div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h4 class="text-sm font-bold text-slate-800 mb-4">Recent Activity</h4>
        <div class="space-y-4">
            @forelse($transactions as $trx)
                <div wire:key="trx-{{ $trx->id }}" class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-full {{ $trx->type == 'credit' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                            @if($trx->type == 'credit')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-slate-700">{{ $trx->description }}</p>
                            <p class="text-[10px] text-slate-400">{{ $trx->created_at->format('M d, H:i') }}</p>
                        </div>
                    </div>
                    <span class="font-black {{ $trx->type == 'credit' ? 'text-green-600' : 'text-slate-900' }}">
                        {{ $trx->type == 'credit' ? '+' : '-' }}₦{{ number_format($trx->amount, 2) }}
                    </span>
                </div>
            @empty
                <p class="text-center text-slate-400 text-xs py-4">No transactions found.</p>
            @endforelse
        </div>
    </div>
</div>
