<?php

namespace App\Livewire\ExpenseCategories;

use App\Models\ExpenseCategory;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CategoryManager extends Component
{
    public $name, $description;

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'min:2',
                Rule::unique('expense_categories')->where(function ($query) {
                    return $query->where('organization_id', Auth::user()->organization_id);
                })
            ],
            'description' => 'nullable|max:255'
        ]);

        ExpenseCategory::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->reset(['name', 'description']);
        session()->flash('message', 'Category added successfully.');
    }

    public function delete($id)
    {
        ExpenseCategory::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.expense-categories.category-manager', [
            'categories' => ExpenseCategory::latest()->get()
        ])->layout('layouts.app');
    }
}
