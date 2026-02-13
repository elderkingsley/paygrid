<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use App\Models\Budget;
use App\Models\ExpenseRequest; // Switched to our new model
use App\Models\User;
use App\Notifications\NewRequisitionSubmitted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ExpenseLogger extends Component
{
    public $budgetId, $amount, $description;

    public function logExpense()
    {
        $this->validate([
            'budgetId' => 'required|exists:budgets,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
        ]);

        $budget = Budget::findOrFail($this->budgetId);
        $user = auth()->user();

        try {
            $expenseRequest = DB::transaction(function () use ($budget, $user) {
                // 1. Check/Reserve the funds in the specific budget if applicable
                // (Assuming your Budget model has a reserveFunds method)
                if (method_exists($budget, 'reserveFunds')) {
                    $budget->reserveFunds($this->amount);
                }

                // 2. Create the ExpenseRequest record
                return ExpenseRequest::create([
                    'organization_id' => $user->organization_id,
                    'user_id' => $user->id,
                    'title' => $this->description, // Mapping description to title
                    'amount' => $this->amount,
                    'status' => 'pending',
                ]);
            });

            // 3. Find Approvers specifically in this Organization using Spatie Team Context
            setPermissionsTeamId($user->organization_id);

            $approvers = User::role(['approver', 'admin'])
                ->where('organization_id', $user->organization_id)
                ->get();

            // 4. Send Notifications
            Notification::send($approvers, new NewRequisitionSubmitted($expenseRequest));

            $this->reset(['amount', 'description', 'budgetId']);
            $this->dispatch('expense-requested');
            session()->flash('message', 'Request submitted! Awaiting manager approval.');

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        // Only show budgets belonging to the user's organization
        return view('livewire.organization.expense-logger', [
            'budgets' => Auth::user()->organization->budgets()->with('department')->get()
        ]);
    }
}
