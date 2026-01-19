<?php

namespace App\Livewire\Expenses;

use App\Models\ExpenseCategory;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateCategoryModal extends Component
{
    public $showModal = false;
    public $name;

    protected $listeners = ['openCreateCategoryModal' => 'open'];

    public function open()
    {
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3|unique:expense_categories,name',
        ]);

        $category = ExpenseCategory::create([
            'id' => (string) Str::uuid(),
            'name' => ucfirst($this->name),
            'organization_id' => auth()->user()->organization_id,
        ]);

        $this->reset(['name', 'showModal']);

        // Notify the user
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Category Added',
            'text' => 'You can now select ' . $category->name . ' from the list.',
        ]);

        // Re-open the main expense modal
        $this->dispatch('openExpenseModal');
    }

    public function render()
    {
        return view('livewire.expenses.create-category-modal');
    }
}
