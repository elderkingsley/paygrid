<?php

namespace App\Livewire\Expenses;

use App\Models\PaymentRequest;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class RequestCenter extends Component
{
    use WithPagination;

    public $filterStatus = 'pending';

    protected $listeners = ['refreshRequests' => '$refresh'];

    /**
     * Handle the Approval Process
     */
    public function approveRequest($requestId)
    {
        $request = PaymentRequest::findOrFail($requestId);

        $request->update([
            'status' => 'approved',
            'approver_id' => Auth::id(), // Critical for the filter logic
        ]);

        session()->flash('message', "Request approved successfully.");
    }

    /**
     * Handle the Disbursement Process (Admin Only)
     */
    public function disburseRequest($requestId)
    {
        // Check if user is admin before proceeding
        if (Auth::user()->role !== 'admin') {
            session()->flash('error', "Unauthorized action.");
            return;
        }

        $request = PaymentRequest::findOrFail($requestId);

        // Later, we will add Paystack API logic here
        $request->update([
            'status' => 'disbursed',
            'disburser_id' => Auth::id()
        ]);

        session()->flash('message', "Payment disbursed successfully.");
    }

    public function render()
    {
        $user = Auth::user();
        $query = PaymentRequest::query()->where('organization_id', $user->organization_id);

        // Scope queries based on status
        $query->where('status', $this->filterStatus);

        // Scope based on roles
        if ($user->role === 'approver') {
            if ($this->filterStatus !== 'pending') {
                // Approvers ONLY see what they personally approved in other tabs
                $query->where('approver_id', $user->id);
            }
        }

        return view('livewire.expenses.request-center', [
            'requests' => $query->with(['category', 'user'])->latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
