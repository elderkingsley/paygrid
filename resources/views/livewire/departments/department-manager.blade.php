<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-24">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Create Department</h2>
            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Department Name</label>
                        <input type="text" wire:model="name" placeholder="e.g. Operations"
                               class="w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Dept Code (Optional)</label>
                        <input type="text" wire:model="code" placeholder="e.g. OPS"
                               class="w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm uppercase">
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Add Department
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h2 class="font-bold text-slate-800 text-lg">Existing Departments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-4 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($departments as $dept)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $dept->name }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-mono font-bold">
                                    {{ $dept->code ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="delete('{{ $dept->id }}')" class="text-slate-400 hover:text-red-500 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-slate-400 italic">No departments created yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
