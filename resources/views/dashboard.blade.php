<x-app-layout>
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            {{-- Balance Card --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Available Balance</span>
                    <span class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div class="text-3xl font-black text-slate-900">₦0.00</div>
            </div>

            {{-- Account Number Card --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Virtual Account</span>
                    <span class="p-2 bg-green-50 text-green-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    </span>
                </div>
                <div class="text-xl font-bold text-slate-800">Assigning Account...</div>
            </div>

            {{-- Monthly Spend Card --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">January Outflow</span>
                    <span class="p-2 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold">↑ 12%</span>
                </div>
                <div class="text-3xl font-black text-slate-900">₦{{ number_format($totalSpent ?? 0, 2) }}</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
             <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                 <h2 class="font-bold text-slate-800">Recent Transactions</h2>
                 {{-- We will eventually put the "Create Expense" button here --}}
             </div>
             <livewire:expenses.expense-list />
        </div>
    </div>
</x-app-layout>
