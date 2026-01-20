<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;

class KycSettings extends Component
{
    public $cac_number, $tin_number, $phone, $email, $org_name;
    public $step = 1; // 1 = Input Details, 2 = Processing
    public $isLoading = false;

    public function mount()
    {
        $user = Auth::user();
        $org = $user->organization;

        $this->org_name = $org->name;
        $this->email = $user->email; // Default to admin email
        $this->phone = $org->phone;
        $this->cac_number = $org->cac_number;
        $this->tin_number = $org->tin_number;
    }

    public function generateAccount()
    {
        $this->validate([
            'cac_number' => 'required|min:5',
            'tin_number' => 'required|min:5',
            'phone' => 'required|min:10',
        ]);

        $this->isLoading = true;
        $org = Auth::user()->organization;

        try {
            // 1. Update Local KYC Data
            $org->update([
                'cac_number' => $this->cac_number,
                'tin_number' => $this->tin_number,
                'phone' => $this->phone,
            ]);

            // 2. Create Paystack Customer (Required first)
            $customerResponse = Http::withToken(config('services.paystack.secret'))
                ->post('https://api.paystack.co/customer', [
                    'email' => $this->email,
                    'first_name' => $this->org_name,
                    'last_name' => 'Organization', // Tagging it as Org
                    'phone' => $this->phone,
                    'metadata' => [
                        'cac_number' => $this->cac_number,
                        'organization_id' => $org->id
                    ]
                ]);

            if (!$customerResponse->successful()) {
                throw new \Exception('Failed to create Paystack Customer: ' . $customerResponse->json()['message']);
            }

            $customerCode = $customerResponse->json()['data']['customer_code'];
            $org->update(['paystack_customer_code' => $customerCode]);

            // 3. Request Dedicated Virtual Account
            $accountResponse = Http::withToken(config('services.paystack.secret'))
                ->post('https://api.paystack.co/dedicated_account', [
                    'customer' => $customerCode,
                    'preferred_bank' => 'wema-bank' // Titan or Wema are standard for Paystack
                ]);


            if (!$accountResponse->successful()) {
                throw new \Exception('Failed to generate Account: ' . $accountResponse->json()['message']);
            }

            // 4. Save Banking Details
            $data = $accountResponse->json()['data'];

            $org->update([
                'virtual_account_number' => $data['account_number'], // Ensure this key is correct
                'virtual_bank_name'      => $data['bank']['name'],   // It's usually nested in 'bank'
                'virtual_account_name'   => $data['account_name'],
                'kyc_verified'           => true,
            ]);

// This ensures your success message actually shows the number
session()->flash('success', 'Virtual Account generated: ' . $data['account_number']);

            $this->dispatch('swal:modal', [
                'icon'  => 'success',
                'title' => 'Treasury Activated!',
                'text'  => 'Your NUBAN is ' . $org->virtual_account_number,
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Generation Failed',
                'text' => $e->getMessage(),
            ]);
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.organization.kyc-settings', [
            'organization' => Auth::user()->organization
        ]);
    }
}
