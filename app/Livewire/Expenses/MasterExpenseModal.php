<?php

namespace App\Livewire\Expenses;

use App\Models\PaymentRequest;
use App\Models\ExpenseCategory;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class MasterExpenseModal extends Component
{
    use WithFileUploads;

    public $showModal = false;

    // Form Fields
    public $category_id, $amount, $details, $receipt;
    public $bank_code, $account_number, $account_name, $bank_name;
    public $save_as_vendor = false;

    // UI State
    public $banks = [];
    public $is_verifying = false;
    public $account_error = null; // Added this property declaration

    public function mount() {
        $response = Http::withToken(config('services.paystack.secret'))->get('https://api.paystack.co/bank');
        $this->banks = $response->successful() ? $response->json()['data'] : [];
    }

    protected $listeners = ['openExpenseModal' => 'open'];
    public function open() {
        $this->showModal = true;
    }

    public function updated($propertyName) {
        if (in_array($propertyName, ['bank_code', 'account_number'])) {
            $this->verifyRecipient();
        }

        // Logic for "Others" category
        if ($propertyName === 'category_id') {
            $category = ExpenseCategory::find($this->category_id);
            if ($category && strtolower($category->name) === 'others') {
                $this->showModal = false;
                $this->dispatch('openCreateCategoryModal');
            }
        }
    }

    public function verifyRecipient() {
        $this->account_error = null;
        $this->account_name = null; // Clear previous name while checking

        if (strlen($this->account_number) > 0 && strlen($this->account_number) < 10) {
            $this->account_error = "Account number must be exactly 10 digits.";
            return;
        }

        if (strlen($this->account_number) === 10 && $this->bank_code) {
            $this->is_verifying = true;

            $response = Http::withToken(config('services.paystack.secret'))
                ->get("https://api.paystack.co/bank/resolve", [
                    'account_number' => $this->account_number,
                    'bank_code' => $this->bank_code,
                ]);

            if ($response->successful()) {
                $this->account_name = $response->json()['data']['account_name'];
                $this->bank_name = collect($this->banks)->firstWhere('code', $this->bank_code)['name'] ?? 'Unknown Bank';
            } else {
                $this->account_error = "Could not verify account. Please check details.";
            }
            $this->is_verifying = false;
        }
    }

    public function submitRequest() {
        $this->validate([
            'category_id' => 'required',
            'amount' => 'required|numeric|min:1',
            'details' => 'required|min:5',
            'account_number' => 'required|digits:10',
            'bank_code' => 'required',
            'account_name' => 'required',
            'receipt' => 'nullable|image|max:2048',
        ]);

        $path = $this->receipt ? $this->receipt->store('receipts', 'public') : null;

        PaymentRequest::create([
            'organization_id' => Auth::user()->organization_id,
            'user_id' => Auth::id(),
            'expense_category_id' => $this->category_id,
            'amount' => $this->amount,
            'details' => $this->details,
            'bank_code' => $this->bank_code,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_name' => $this->account_name,
            'receipt_path' => $path,
            'status' => 'pending'
        ]);

        if ($this->save_as_vendor) {
            Vendor::firstOrCreate(['account_number' => $this->account_number], [
                'name' => $this->account_name,
                'bank_name' => $this->bank_name,
                'organization_id' => Auth::user()->organization_id
            ]);
        }

        $finalAmount = $this->amount;

        $this->reset(['category_id', 'amount', 'details', 'receipt', 'bank_code', 'account_number', 'account_name', 'bank_name', 'save_as_vendor', 'account_error']);
        $this->showModal = false;

        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Request Submitted!',
            'text' => 'Your expense request for ' . number_format($finalAmount, 2) . ' has been sent for approval.',
        ]);

        $this->dispatch('refreshRequests');
    }

    public function render()
{
    return view('livewire.expenses.master-expense-modal', [
        'categories' => ExpenseCategory::where('organization_id', auth()->user()->organization_id)
            ->orderByRaw("CASE WHEN name = 'Others' THEN 1 ELSE 0 END ASC")
            ->orderBy('name', 'asc')
            ->get()
    ]);
}
}
