<div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Vendor & Date</th>
                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-center">Items</th>
                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($expenses as $expense)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="font-bold text-gray-900">{{ $expense->vendor->name }}</div>
                    <div class="text-xs text-gray-400">{{ $expense->payment_date->format('d M, Y') }}</div>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-md text-xs font-medium">
                        {{ $expense->items->count() }} items
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-bold text-gray-900">₦{{ number_format($expense->total_amount, 2) }}</span>
                </td>
                <td class="px-6 py-4 text-right">
                    <span class="px-3 py-1 rounded-full text-xs font-bold
                        {{ $expense->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                        {{ strtoupper($expense->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
