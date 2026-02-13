<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Budget extends Model
{   protected $fillable = [
        'organization_id',
        'department_id',
        'description',
        'allocated_amount',
        'spent_amount',
        'reserved_amount'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function recordExpense($amount, $description)
    {
        return DB::transaction(function () use ($amount, $description) {
            // 1. Update the Department Budget
            $this->increment('spent_amount', $amount);

            // 2. Update the Main Organization Wallet
            $this->organization->decrement('wallet_balance', $amount);

            // 3. Create a Transaction Log for the audit trail
            return $this->organization->transactions()->create([
                'amount' => $amount,
                'type' => 'debit',
                'description' => "Expense: {$description} (Dept: {$this->department->name})",
                'reference' => 'EXP-' . strtoupper(bin2hex(random_bytes(4))), // Unique Ref
            ]);
        });
    }

    public function reserveFunds($amount)
    {
        // Check if there's enough room in the budget (Allocated - Spent - already Reserved)
        $available = $this->allocated_amount - ($this->spent_amount + $this->reserved_amount);

        if ($amount > $available) {
            throw new \Exception("Insufficient departmental funds available.");
        }

        $this->increment('reserved_amount', $amount);
    }


}
