<div x-data="{ open: false }"
     x-on:open-vendor-modal.window="open = true"
     x-on:close-modal.window="open = false"
     x-on:vendor-added.window="open = false"
     x-cloak> {{-- Fixed the closing tag here --}}

    <div x-show="open"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         x-transition {{-- Added transition for a smoother feel --}}
         x-cloak>

        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md" @click.away="open = false">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Add New Vendor</h2>

            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vendor Name</label>
                        <input type="text" wire:model="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        @error('name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Rest of your form fields stay exactly the same --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                        <input type="text" wire:model="bank_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        @error('bank_name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Account Number</label>
                            <input type="text" wire:model="account_number" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                            @error('account_number') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Account Name</label>
                            <input type="text" wire:model="account_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                            @error('account_name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3 border-t pt-4">
                    <button @click="open = false" type="button" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">Cancel</button>
                    <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 transition">
                        <span wire:loading.remove>Save Vendor</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
