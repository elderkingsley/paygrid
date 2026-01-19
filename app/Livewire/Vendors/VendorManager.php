<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class VendorManager extends Component
{
    // For the "Create" part of the page
    public $name, $bank_name, $account_number, $account_name;

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2',
            'account_number' => 'nullable|numeric',
        ]);

        Vendor::create([
            'name' => $this->name,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
        ]);

        $this->reset();
        session()->flash('message', 'Vendor added successfully.');
    }

    public function delete($id)
    {
        Vendor::where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.vendors.vendor-manager', [
            'vendors' => Vendor::latest()->get()
        ])->layout('layouts.app');
    }
}
