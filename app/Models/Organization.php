<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Organization extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'paystack_customer_code',
        'virtual_account_number',
        'virtual_bank_name',
        'virtual_account_name',
        'wallet_balance',
        'kyc_verified',
        'slug'
    ];

    /**
     * Relationship to Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Fetch live balance from Paystack API
     */

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Calculate money not yet tied to a specific budget
     */
    public function getUnallocatedBalanceAttribute()
    {
        $totalAllocated = $this->budgets()->sum('allocated_amount');
        return ($this->wallet_balance ?? 0) - $totalAllocated;
    }

    /**
 * Deduct funds from the wallet securely
 */
    public function deductFromWallet(float $amount, string $description, $categoryId = null)
    {
        // 1. Check for sufficient funds
        if ($this->wallet_balance < $amount) {
            throw new \Exception("Insufficient funds in the organization wallet.");
        }

        return \DB::transaction(function () use ($amount, $description, $categoryId) {
            // 2. Create the transaction record (Debit)
            $this->transactions()->create([
                'amount' => $amount,
                'type' => 'debit', // or 'expense'
                'description' => $description,
                'category_id' => $categoryId,
                'status' => 'success',
            ]);

            // 3. Update the wallet balance
            $this->decrement('wallet_balance', $amount);

            return true;
        });
    }
}
