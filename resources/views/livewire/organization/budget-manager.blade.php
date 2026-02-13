<div class="space-y-6">
    {{-- 1. Allocation Form Section --}}
    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <div class="mb-6">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Allocate Departmental Budget</h3>
            <p class="text-xs text-slate-500">Distribute funds from the main treasury to a specific department.</p>
        </div>

        <form wire:submit.prevent="createBudget" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Department</label>
                    <select wire:model.live="selectedDepartmentId" class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-blue-500 focus:ring-blue-500 transition">
                        <option value="">-- Select Department --</option>
                        @foreach($departments ?? [] as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                        <option value="add_new" class="text-blue-600 font-bold">+ Create New Department</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Allocation Amount (₦)</label>
                    <input type="number" wire:model="amount" placeholder="0.00"
                           class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-blue-500 focus:ring-blue-500 transition">
                </div>
            </div>

            @if($showNewInput)
                <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 animate-in fade-in slide-in-from-top-2 duration-300">
                    <label class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">New Department Name</label>
                    <input type="text" wire:model="newDepartmentName" placeholder="e.g. Research & Development"
                           class="w-full mt-1 rounded-xl border-blue-200 text-sm focus:ring-blue-500">
                </div>
            @endif

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Allocation Notes / Description</label>
                <textarea wire:model="description" rows="2"
                          placeholder="What is this money for? (e.g. Q1 Logistics Fuel Subsidy)"
                          class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-blue-500 focus:ring-blue-500 transition"></textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm hover:bg-blue-600 transition-all shadow-md active:scale-95">
                    Confirm Allocation
                </button>
            </div>
        </form>
    </div>

    {{-- 2. Budget Progress List --}}
    <div class="space-y-4">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest ml-2">Departmental Limits & Holds</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($budgets ?? [] as $budget)
                @php
                    $totalCommitted = $budget->spent_amount + $budget->reserved_amount;
                    $percentSpent = $budget->allocated_amount > 0 ? ($budget->spent_amount / $budget->allocated_amount) * 100 : 0;
                    $percentReserved = $budget->allocated_amount > 0 ? ($budget->reserved_amount / $budget->allocated_amount) * 100 : 0;
                @endphp

                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="font-bold text-slate-800">{{ $budget->department->name }}</h4>
                            <p class="text-[10px] text-slate-400 font-medium truncate max-w-[150px]">{{ $budget->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-black text-slate-800 block">₦{{ number_format($budget->allocated_amount, 0) }}</span>
                            <span class="text-[8px] text-slate-400 uppercase font-bold">Limit</span>
                        </div>
                    </div>

                    {{-- Multi-State Progress Bar --}}
                    <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden flex">
                        {{-- Spent --}}
                        <div class="h-full bg-blue-600 transition-all duration-700" style="width: {{ $percentSpent }}%"></div>
                        {{-- Reserved (Waiting Approval) --}}
                        <div class="h-full bg-amber-400 transition-all duration-700 opacity-60" style="width: {{ $percentReserved }}%"></div>
                    </div>

                    <div class="flex justify-between mt-3 text-[9px] font-bold uppercase tracking-tight">
                        <div class="space-x-3">
                            <span class="text-blue-600">Spent: ₦{{ number_format($budget->spent_amount, 0) }}</span>
                            <span class="text-amber-500">Held: ₦{{ number_format($budget->reserved_amount, 0) }}</span>
                        </div>
                        <span class="text-slate-400">Available: ₦{{ number_format($budget->allocated_amount - $totalCommitted, 0) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
