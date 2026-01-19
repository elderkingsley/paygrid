<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'expense_id',
        'description',
        'category',
        'amount'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
