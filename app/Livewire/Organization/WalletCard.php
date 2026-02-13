<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class WalletCard extends Component
{
    public function render()
    {
        $organization = Auth::user()->organization;

        // Fetch the last 5 transactions for the history list
        $transactions = Transaction::where('organization_id', $organization->id)
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.organization.wallet-card', [
            'balance' => auth()->user()->organization->wallet_balance,
            'transactions' => $transactions,
            'accountNumber' => $organization->virtual_account_number,
            'bankName' => $organization->virtual_bank_name,
        ]);
    }
}
