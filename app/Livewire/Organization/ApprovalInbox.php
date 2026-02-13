<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Requisition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\RequisitionRejected;

class ApprovalInbox extends Component
{
    protected $listeners = ['expense-requested' => '$refresh'];

    public function approve($id)
    {
        // Real security check
        if (!auth()->user()->can('approve-request')) {
            abort(403);
        }
        $requisition = Requisition::findOrFail($id);

        $requisition->update([
            'status' => 'approved',
            'approver_id' => auth()->id(),
            'approved_at' => now(),
        ]);

        session()->flash('message', 'Request approved. Sent to Disburser.');
    }

    public function reject($id)
    {
        $requisition = Requisition::findOrFail($id);

        \DB::transaction(function () use ($requisition) {
            // 1. Release the held funds back to the budget
            $requisition->budget->decrement('reserved_amount', $requisition->amount);

            // 2. Update status
            $requisition->update(['status' => 'rejected']);
        });

        // 3. Notify the person who made the request
        $requisition->user->notify(new RequisitionRejected($requisition));

        session()->flash('error', 'Request rejected and funds released.');
    }

    public function render()
    {
        $requests = Requisition::where('organization_id', auth()->user()->organization_id)
            ->where('status', 'pending')
            ->with(['user', 'department', 'budget'])
            ->latest()
            ->get();

        return view('livewire.organization.approval-inbox', compact('requests'));
    }
}
