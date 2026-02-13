<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Requisition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RequisitionDisbursed;

class DisbursementQueue extends Component
{
    protected $listeners = ['expense-approved' => '$refresh'];

    public function disburse($id)
    {
        $requisition = Requisition::findOrFail($id);
        $budget = $requisition->budget;

        DB::transaction(function () use ($requisition, $budget) {
            // 1. Move money from 'Reserved' to 'Spent' in the Budget
            $budget->decrement('reserved_amount', $requisition->amount);
            $budget->increment('spent_amount', $requisition->amount);

            // 2. Deduct from the Main Organization Wallet
            $budget->organization->decrement('wallet_balance', $requisition->amount);

            // 3. Finalize the Requisition Status
            $requisition->update([
                'status' => 'disbursed',
                'disburser_id' => Auth::id(),
                'disbursed_at' => now(),
            ]);

            // 4. Create the Ledger Transaction (for the bank statement view)
            $budget->organization->transactions()->create([
                'amount' => $requisition->amount,
                'type' => 'debit',
                'description' => "Disbursed: {$requisition->description} ({$requisition->department->name})",
                'reference' => 'PAY-' . strtoupper(bin2hex(random_bytes(4))),
            ]);
        });
        $requisition->user->notify(new RequisitionDisbursed($requisition));

        $this->dispatch('expense-disbursed'); // Refresh the progress bars!
        session()->flash('message', 'Funds successfully disbursed and ledger updated.');
    }

    public function render()
    {
        $queue = Requisition::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'approved')
            ->with(['user', 'department'])
            ->latest()
            ->get();

        return view('livewire.organization.disbursement-queue', compact('queue'));
    }
}
