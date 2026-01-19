<div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak class="fixed inset-0 z-[110] overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-md bg-white rounded-[2rem] shadow-2xl p-8">
            <h3 class="text-lg font-black text-slate-900 uppercase italic">Add New Category</h3>
            <p class="text-xs text-slate-500 mb-6">Create a custom category for your expense requests.</p>

            <div class="space-y-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category Name</label>
                    <input type="text" wire:model="name" placeholder="e.g. Office Supplies"
                        class="w-full mt-1 border-slate-200 rounded-2xl p-3 text-sm font-bold focus:ring-blue-600">
                    @error('name') <span class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button @click="open = false" type="button" class="flex-1 py-3 text-xs font-black text-slate-400 uppercase">Cancel</button>
                    <button wire:click="save" class="flex-[2] bg-blue-600 text-white py-3 rounded-xl font-black shadow-lg hover:bg-blue-700 transition">
                        SAVE CATEGORY
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
