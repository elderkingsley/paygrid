<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Budget;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class BudgetManager extends Component
{
    public $selectedDepartmentId; // Will hold UUID or 'add_new'
    public $newDepartmentName;
    public $amount;
    public $showNewInput = false;

    public function updatedSelectedDepartmentId($value)
    {
        $this->showNewInput = ($value === 'add_new');
    }

    public $description; // Add this property

    public function createBudget()
    {
        $org = auth()->user()->organization;

        $this->validate([
            'amount' => 'required|numeric|min:1',
            'selectedDepartmentId' => 'required',
            'description' => 'nullable|string|max:255', // Validation rule
        ]);

        if ($this->selectedDepartmentId === 'add_new') {
            $dept = $org->departments()->create(['name' => $this->newDepartmentName]);
            $this->selectedDepartmentId = $dept->id;
        }

        Budget::create([
            'organization_id' => $org->id,
            'department_id' => $this->selectedDepartmentId,
            'description' => $this->description, // Save the description
            'allocated_amount' => $this->amount,
        ]);

        $this->reset(['selectedDepartmentId', 'newDepartmentName', 'amount', 'description', 'showNewInput']);
    }

    public function render()
    {
        $org = auth()->user()->organization;

        return view('livewire.organization.budget-manager', [
            // Use ?? collect() to ensure it's never null
            'budgets' => $org?->budgets()->with('department')->get() ?? collect(),
            'departments' => $org?->departments ?? collect(),
            'unallocated' => $org?->unallocated_balance ?? 0
        ]);
    }
}
