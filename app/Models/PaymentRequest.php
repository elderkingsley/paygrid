<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentRequest extends Model
{
    use HasFactory, HasUuids;

    // Forces Laravel to treat the ID as a string (UUID) rather than an integer
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'organization_id',
        'user_id',
        'expense_category_id',
        'amount',
        'details',
        'bank_code',
        'bank_name',
        'account_number',
        'account_name',
        'receipt_path',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
}
