<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Transaction History</h3>

        <div class="flex gap-2">
            <input type="text" wire:model.live="search" placeholder="Search expenses..."
                   class="text-xs rounded-xl border-slate-200 bg-slate-50 focus:ring-blue-500 w-full md:w-64">

            <select wire:model.live="status" class="text-xs rounded-xl border-slate-200 bg-slate-50 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="disbursed">Disbursed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Requester / Dept</th>
                    <th class="px-6 py-4">Description</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($history as $item)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 text-[11px] text-slate-500 font-medium">
                            {{ $item->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-[11px] font-bold text-slate-800">{{ $item->user->name }}</p>
                            <p class="text-[9px] text-slate-400 uppercase font-black">{{ $item->department->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-[11px] text-slate-600 italic">
                            {{ $item->description }}
                        </td>
                        <td class="px-6 py-4 text-[11px] font-black text-slate-900">
                            ₦{{ number_format($item->amount, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $colors = [
                                    'pending' => 'bg-amber-100 text-amber-600',
                                    'approved' => 'bg-blue-100 text-blue-600',
                                    'disbursed' => 'bg-emerald-100 text-emerald-600',
                                    'rejected' => 'bg-red-100 text-red-600',
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase {{ $colors[$item->status] ?? 'bg-slate-100' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-4 bg-slate-50/30">
        {{ $history->links() }}
    </div>
</div>
