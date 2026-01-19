<?php

namespace App\Livewire\Expenses;

use Livewire\Component;
use App\Models\Vendor;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class CreateExpense extends Component
{
    protected $listeners = ['vendor-added' => '$refresh'];
    public $vendor_id;
    public $payment_date;

    // Listen for the signal from the CreateVendor modal

    public $items = [
        ['description' => '', 'category' => '', 'amount' => 0]
    ];

    public function mount()
    {
        // Only set the default date here
        $this->payment_date = now()->format('Y-m-d');
    }

    public function addItem()
    {
        $this->items[] = ['description' => '', 'category' => '', 'amount' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate([
            'vendor_id' => 'required',
            'payment_date' => 'required|date',
            'items.*.description' => 'required',
            'items.*.amount' => 'required|numeric|min:1',
        ]);

        $total = collect($this->items)->sum('amount');

        // The BelongsToOrganization trait will handle organization_id automatically
        $expense = Expense::create([
            'vendor_id' => $this->vendor_id,
            'user_id' => Auth::id(),
            'payment_date' => $this->payment_date,
            'total_amount' => $total,
            'status' => 'pending',
        ]);

        foreach ($this->items as $item) {
            $expense->items()->create($item);
        }

        $this->dispatch('expense-saved');
        $this->reset(['vendor_id', 'items']);
        $this->items = [['description' => '', 'category' => '', 'amount' => 0]];

        session()->flash('status', 'Expense recorded successfully!');
    }

    public function render()
    {
        return view('livewire.expenses.create-expense', [
            // This ensures the list is ALWAYS fresh, even after adding a new vendor
            'vendors' => Vendor::all()
        ]);
    }
}
