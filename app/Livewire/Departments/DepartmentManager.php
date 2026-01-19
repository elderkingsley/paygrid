<?php

namespace App\Livewire\Departments;

use App\Models\Department;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DepartmentManager extends Component
{
    public $name, $code;

    public function save()
    {
        // Unique validation, but restricted to the user's organization
        $this->validate([
            'name' => [
                'required',
                'min:2',
                Rule::unique('departments')->where(function ($query) {
                    return $query->where('organization_id', Auth::user()->organization_id);
                })
            ],
            'code' => 'nullable|max:5'
        ]);

        Department::create([
            'name' => $this->name,
            'code' => strtoupper($this->code),
            // organization_id is handled by your BelongsToOrganization trait!
        ]);

        $this->reset(['name', 'code']);
        session()->flash('message', 'Department added successfully.');
    }

    public function delete($id)
    {
        // Security check: Ensure they can only delete their own org's department
        Department::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.departments.department-manager', [
            // The trait automatically filters this to the current organization!
            'departments' => Department::latest()->get()
        ])->layout('layouts.app');
    }
}
