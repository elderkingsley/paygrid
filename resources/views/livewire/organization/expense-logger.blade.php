<div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.15em]">Log New Request</h3>
        <div class="h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></div>
    </div>

    <form wire:submit.prevent="logExpense" class="space-y-6">
        {{-- Budget Selection --}}
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Target Budget Line</label>
            <select wire:model="budgetId"
                class="w-full mt-1.5 bg-slate-50 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500 p-3.5 transition-all">
                <option value="">-- Select Departmental Budget --</option>
                @foreach($budgets as $budget)
                    @php
                        $remaining = $budget->allocated_amount - $budget->spent_amount;
                    @endphp
                    <option value="{{ $budget->id }}">
                        {{ $budget->department->name }} — (₦{{ number_format($remaining, 0) }} avail.)
                    </option>
                @endforeach
            </select>
            @error('budgetId') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Amount Input --}}
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Amount (₦)</label>
                <div class="relative mt-1.5">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₦</span>
                    <input type="number" wire:model="amount"
                        class="w-full bg-slate-50 border-slate-100 rounded-2xl text-sm font-black text-slate-800 pl-8 p-3.5 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="0.00">
                </div>
                @error('amount') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Description Input --}}
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Purpose / Description</label>
                <input type="text" wire:model="description"
                    class="w-full mt-1.5 bg-slate-50 border-slate-100 rounded-2xl text-sm font-bold text-slate-700 p-3.5 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="e.g. Office supplies">
                @error('description') <span class="text-red-500 text-[10px] font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit"
            class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-blue-600 shadow-lg shadow-slate-200 hover:shadow-blue-200 active:scale-[0.98] transition-all duration-200">
            Submit Request for Approval
        </button>
    </form>

    {{-- Feedback Messages --}}
    @if (session()->has('error'))
        <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-xl text-red-600 text-[10px] font-black uppercase text-center">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="mt-4 p-3 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-600 text-[10px] font-black uppercase text-center">
            {{ session('message') }}
        </div>
    @endif
</div>
