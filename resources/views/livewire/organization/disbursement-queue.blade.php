<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Disbursement Queue</h3>
        <span class="bg-emerald-100 text-emerald-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ $queue->count() }} Ready</span>
    </div>

    <div class="space-y-4">
        @forelse($queue as $item)
            <div class="p-4 border border-emerald-50 bg-emerald-50/20 rounded-2xl flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-emerald-700 font-mono">₦{{ number_format($item->amount, 2) }}</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter italic">Approved by {{ $item->approver->name }}</span>
                    </div>
                    <p class="text-[11px] text-slate-600 mt-1 font-semibold">{{ $item->description }}</p>
                </div>

                <button wire:click="disburse({{ $item->id }})"
                        class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-[10px] font-black hover:bg-emerald-700 transition shadow-sm shadow-emerald-200 uppercase tracking-widest">
                    Release Funds
                </button>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-xs text-slate-400 font-medium italic">No funds awaiting disbursement.</p>
            </div>
        @endforelse
    </div>
</div>
