<div class="space-y-6">
    {{-- Header remains the same --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 italic uppercase">Request Center</h1>
            <p class="text-sm text-slate-500 font-bold">Manage and authorize organizational disbursements</p>
        </div>

        <div class="flex bg-slate-200 p-1 rounded-xl">
            @foreach(['pending', 'approved', 'disbursed'] as $status)
                <button wire:click="$set('filterStatus', '{{ $status }}')"
                    class="px-4 py-2 rounded-lg text-xs font-black uppercase tracking-widest transition-all {{ $filterStatus == $status ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ $status }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="p-4 bg-green-100 text-green-700 rounded-2xl font-bold text-xs uppercase tracking-widest">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Requester / Details</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Category</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 text-right">Amount</th>
                    <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Recipient</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($requests as $req)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $req->user->name }}</div>
                            <div class="text-xs text-slate-500 line-clamp-1">{{ $req->details }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-black uppercase">
                                {{ $req->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="font-black text-slate-900">₦{{ number_format($req->amount, 2) }}</div>
                            @if($req->receipt_path)
                                <a href="{{ Storage::url($req->receipt_path) }}" target="_blank" class="text-[9px] font-bold text-blue-500 hover:underline uppercase">View Invoice</a>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-bold text-slate-800">{{ $req->account_name }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $req->bank_name }} • {{ $req->account_number }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                {{-- 1. APPROVE BUTTON: Visible to Admins and Approvers in Pending --}}
                                @if($req->status == 'pending' && in_array(auth()->user()->role, ['admin', 'approver']))
                                    <button wire:click="approveRequest('{{ $req->id }}')"
                                        class="bg-slate-900 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase hover:bg-blue-600 transition">
                                        Approve
                                    </button>
                                @endif

                                {{-- 2. DISBURSE BUTTON: ONLY visible to Admins in Approved --}}
                                @if($req->status == 'approved' && auth()->user()->role === 'admin')
                                    <button wire:click="disburseRequest('{{ $req->id }}')"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase hover:bg-blue-700 shadow-lg shadow-blue-200 transition">
                                        Disburse
                                    </button>
                                @endif

                                {{-- 3. STATUS BADGE: For already disbursed items --}}
                                @if($req->status == 'disbursed')
                                    <span class="text-[10px] font-black text-green-500 uppercase">Paid</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic">No {{ $filterStatus }} requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-50">
            {{ $requests->links() }}
        </div>
    </div>
</div>
