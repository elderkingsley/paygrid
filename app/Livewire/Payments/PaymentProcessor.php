<?php

namespace App\Livewire\Payments;

use App\Models\Vendor;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class PaymentProcessor extends Component
{
    public $account_number, $bank_code, $account_name;
    public $banks = [];
    public $is_verifying = false;
    public $save_as_vendor = false;
    public $vendor_name;

    public function mount()
    {
        // Fetch list of Nigerian banks from Paystack
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get('https://api.paystack.co/bank');

        if ($response->successful()) {
            $this->banks = $response->json()['data'];
        }
    }

    // This runs automatically whenever bank_code or account_number changes
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['bank_code', 'account_number'])) {
            $this->verifyAccount();
        }
    }

    public function verifyAccount()
    {
        if (strlen($this->account_number) === 10 && $this->bank_code) {
            $this->is_verifying = true;
            $this->account_name = '';

            $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
                ->get("https://api.paystack.co/bank/resolve", [
                    'account_number' => $this->account_number,
                    'bank_code' => $this->bank_code,
                ]);

            if ($response->successful()) {
                $this->account_name = $response->json()['data']['account_name'];
                $this->vendor_name = $this->account_name; // Default vendor name to account name
            } else {
                $this->account_name = "Could not verify account.";
            }
            $this->is_verifying = false;
        }
    }

    public function processPayment()
    {
        $this->validate([
            'account_number' => 'required|digits:10',
            'bank_code' => 'required',
            'account_name' => 'required',
        ]);

        // 1. If user checked "Save as Vendor", create the vendor record
        if ($this->save_as_vendor) {
            $bankName = collect($this->banks)->firstWhere('code', $this->bank_code)['name'];

            Vendor::firstOrCreate(
                ['account_number' => $this->account_number],
                [
                    'name' => $this->vendor_name,
                    'bank_name' => $bankName,
                    'account_name' => $this->account_name,
                    'organization_id' => Auth::user()->organization_id
                ]
            );
        }

        // 2. LOGIC FOR ACTUAL PAYMENT TRANSFER GOES HERE LATER
        session()->flash('success', 'Verification successful! Payment processing initiated.');
    }

    public function render()
    {
        return view('livewire.payments.payment-processor')->layout('layouts.app');
    }
}
