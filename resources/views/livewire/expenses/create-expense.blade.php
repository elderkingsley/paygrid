<div class="p-6 bg-white rounded-lg shadow">
    {{-- 1. Main Expense Form --}}
    <form wire:submit.prevent="save">

        {{-- Display Validation Errors for the Expense --}}
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-4 mb-6">
            {{-- Vendor Selection --}}
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block font-medium text-sm text-gray-700">Vendor</label>

                    {{-- This button triggers the modal sitting outside the form --}}
                    <button type="button"
                            @click="$dispatch('open-vendor-modal')"
                            class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase tracking-wider">
                        + New Vendor
                    </button>
                </div>

                <select wire:model="vendor_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                    <option value="">Select Vendor</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Payment Date --}}
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-1">Payment Date</label>
                <input type="date" wire:model="payment_date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
            </div>
        </div>

        {{-- Line Items Table --}}
        <div class="mb-4">
            <h3 class="text-lg font-semibold mb-2 text-gray-800 border-b pb-1">Line Items</h3>
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-bold text-gray-500 uppercase">
                        <th class="pb-2">Description</th>
                        <th class="pb-2 px-2">Category</th>
                        <th class="pb-2 w-32">Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                    <tr class="py-2" wire:key="expense-item-{{ $index }}">
                        <td class="py-1">
                            <input type="text" wire:model="items.{{ $index }}.description"
                                   class="w-full border-gray-300 rounded shadow-sm text-sm"
                                   placeholder="Item details...">
                        </td>
                        <td class="py-1 px-2">
                            <input type="text" wire:model="items.{{ $index }}.category"
                                   class="w-full border-gray-300 rounded shadow-sm text-sm"
                                   placeholder="e.g. Logistics">
                        </td>
                        <td class="py-1">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-500 text-sm">₦</span>
                                <input type="number" wire:model="items.{{ $index }}.amount"
                                       class="w-full border-gray-300 rounded shadow-sm text-sm pl-6"
                                       placeholder="0.00" step="0.01">
                            </div>
                        </td>
                        <td class="py-1 text-right">
                            <button type="button" wire:click="removeItem({{ $index }})"
                                    class="text-red-400 hover:text-red-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center border-t pt-6">
            <button type="button" wire:click="addItem"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 active:bg-gray-300 transition ease-in-out duration-150">
                + Add Another Line
            </button>

            <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition ease-in-out duration-150 shadow-md">
                Submit Total Expense
            </button>
        </div>
    </form>

    {{-- 2. The Vendor Modal Component (Placed OUTSIDE the <form> tags) --}}
    <div class="mt-4">
        <livewire:vendors.create-vendor />
    </div>
</div>
