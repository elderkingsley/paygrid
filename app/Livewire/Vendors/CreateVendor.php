<?php

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateVendor extends Component
{
    public $name;
    public $bank_name;
    public $account_number;
    public $account_name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'bank_name' => 'nullable|string',
        'account_number' => 'nullable|numeric',
        'account_name' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();
        $this->validate();

        // The BelongsToOrganization trait handles organization_id
        Vendor::create([
            'name' => $this->name,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
        ]);

        $this->reset();

        // This is key: tell the parent to refresh and close the modal
        $this->dispatch('vendor-added');

        // This helper for Alpine.js will close the modal
        $this->dispatch('close-modal');

        session()->flash('message', 'Vendor successfully added.');
    }

    public function render()
    {
        return view('livewire.vendors.create-vendor');
    }
}
