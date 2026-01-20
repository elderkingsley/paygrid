<?php

namespace App\Livewire\Organization;

use App\Models\Department;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DepartmentManager extends Component
{
    public $name; // For creating new departments

    public function createDepartment()
    {
        $this->validate(['name' => 'required|min:3']);

        Department::create([
            'organization_id' => Auth::user()->organization_id,
            'name' => $this->name,
        ]);

        $this->reset('name');
        $this->dispatch('swal:modal', ['type' => 'success', 'title' => 'Department Created']);
    }

    public function generateDepartmentWallet($departmentId)
    {
        $dept = Department::find($departmentId);
        $org = Auth::user()->organization;

        try {
            // 1. Create a "Customer" for this specific department
            $customerResponse = Http::withToken(config('services.paystack.secret'))
                ->post('https://api.paystack.co/customer', [
                    'email' => strtolower(str_replace(' ', '.', $dept->name)) . '@' . $org->id . '.com',
                    'first_name' => $org->name,
                    'last_name' => "({$dept->name})",
                    'phone' => $org->phone,
                ]);

            $customerCode = $customerResponse->json()['data']['customer_code'];

            // 2. Generate Dedicated Account
            $accountResponse = Http::withToken(config('services.paystack.secret'))
                ->post('https://api.paystack.co/dedicated_account', [
                    'customer' => $customerCode,
                    'preferred_bank' => 'wema-bank'
                ]);

            $data = $accountResponse->json()['data'];

            // 3. Save to Department
            $dept->update([
                'virtual_account_number' => $data['account_number'],
                'virtual_account_name' => $data['account_name'],
                'paystack_dedicated_account_id' => $data['id']
            ]);

            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Wallet Active',
                'text' => "Virtual account generated for {$dept->name}"
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal:modal', ['type' => 'error', 'title' => 'Error', 'text' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.organization.department-manager', [
            'departments' => Department::where('organization_id', Auth::user()->organization_id)->get()
        ])->layout('layouts.app');
    }
}
