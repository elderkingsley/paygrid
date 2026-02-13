<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Requisition;
use Livewire\WithPagination;

class ExpenseHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function render()
    {
        $history = Requisition::where('organization_id', auth()->user()->organization_id)
            ->when($this->search, function($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->with(['user', 'department', 'approver', 'disburser'])
            ->latest()
            ->paginate(10);

        return view('livewire.organization.expense-history', compact('history'));
    }
}
