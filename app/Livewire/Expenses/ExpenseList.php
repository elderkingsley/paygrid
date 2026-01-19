<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ExpenseList extends Component
{
    // This tells Livewire to refresh this list whenever an expense is saved
    protected $listeners = ['expense-saved' => '$refresh'];

    public function render()
    {
        return view('livewire.expenses.expense-list', [
            'expenses' => Expense::with(['vendor', 'items'])
                ->latest()
                ->paginate(10)
        ]);
    }
}
