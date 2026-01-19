<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Add New Vendor</h2>
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Business Name</label>
                    <input type="text" wire:model="name" class="w-full border-slate-200 rounded-xl shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Bank Name</label>
                    <input type="text" wire:model="bank_name" class="w-full border-slate-200 rounded-xl shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Account Number</label>
                    <input type="text" wire:model="account_number" class="w-full border-slate-200 rounded-xl shadow-sm">
                </div>
                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200">
                    Save Vendor
                </button>
            </form>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100"><h2 class="font-bold text-slate-800">Vendor Directory</h2></div>
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Vendor</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase">Bank Details</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($vendors as $vendor)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-700">{{ $vendor->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $vendor->bank_name }} <br> {{ $vendor->account_number }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="delete('{{ $vendor->id }}')" class="text-slate-400 hover:text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
