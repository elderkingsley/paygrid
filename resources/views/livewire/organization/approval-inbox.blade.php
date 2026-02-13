<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pending Approvals</h3>
        <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-1 rounded-full">{{ $requests->count() }} New</span>
    </div>

    <div class="space-y-4">
        @forelse($requests as $req)
            <div class="p-4 border border-slate-50 bg-slate-50/30 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-800">₦{{ number_format($req->amount, 2) }}</span>
                        <span class="text-[10px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded-md font-bold uppercase">{{ $req->department->name }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1 font-medium italic">"{{ $req->description }}"</p>
                    <p class="text-[9px] text-slate-400 mt-1 font-bold uppercase">Requested by: {{ $req->user->name }}</p>
                </div>

                <div class="flex gap-2">
                    <button wire:click="reject({{ $req->id }})" class="px-4 py-2 text-[10px] font-bold text-red-500 hover:bg-red-50 rounded-xl transition">Reject</button>
                    <button wire:click="approve({{ $req->id }})" class="px-4 py-2 text-[10px] font-bold bg-slate-900 text-white hover:bg-blue-600 rounded-xl transition">Approve</button>
                </div>
            </div>
        @empty
            <p class="text-center py-6 text-xs text-slate-400 font-medium">No pending requests at the moment.</p>
        @endforelse
    </div>
</div>
