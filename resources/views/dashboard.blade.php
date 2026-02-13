<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- Left Column: Treasury Overview --}}
            <div class="lg:col-span-4 space-y-6">
                <h3 class="text-lg font-black text-slate-800 tracking-tight ml-2">Main Treasury</h3>

                @livewire('organization.wallet-card')

                <div class="bg-blue-600 rounded-3xl p-6 text-white shadow-lg shadow-blue-200">
                    <p class="text-[10px] font-bold uppercase opacity-70 text-blue-100">Total Monthly Outflow</p>
                    <p class="text-2xl font-black">₦{{ number_format($totalSpent ?? 0, 2) }}</p>
                </div>
            </div>

            {{-- Right Column: Actions & Workflow --}}
            <div class="lg:col-span-8 space-y-10">

                {{-- Request Section: Visible to Requesters & Admins --}}
                @role(['requester', 'admin'])
                    <section>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight ml-2 mb-4">Request Funds</h3>
                        @livewire('organization.expense-logger')
                    </section>
                @endrole

                {{-- Approval & Disbursement Workflow --}}
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    {{-- Approver View --}}
                    @role(['approver', 'admin'])
                        <section>
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-2 mb-3">Pending Approvals</h3>
                            @livewire('organization.approval-inbox')
                        </section>
                    @endrole

                    {{-- Disburser View --}}
                    @role(['disburser', 'admin'])
                        <section>
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-2 mb-3">Disbursement Queue</h3>
                            @livewire('organization.disbursement-queue')
                        </section>
                    @endrole
                </div>

                {{-- Budget Management (Keep here or move to sidebar as well) --}}
                @role('admin')
                    <hr class="border-slate-100">
                    <section>
                        <h3 class="text-lg font-black text-slate-800 tracking-tight ml-2 mb-4">Budget Overview</h3>
                        @livewire('organization.budget-manager')
                    </section>
                @endrole
            </div>
        </div>

        {{-- Footer Section: History --}}
        <div class="mt-12 border-t border-slate-100 pt-10">
            <h3 class="text-lg font-black text-slate-800 tracking-tight ml-2 mb-6">Activity History</h3>
            @livewire('organization.expense-history')
        </div>
    </div>
</x-app-layout>
