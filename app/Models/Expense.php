<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasUuids, BelongsToOrganization;
    protected $fillable = [
        'vendor_id',
        'user_id',
        'payment_date',
        'total_amount',
        'status'
    ];

    protected $casts = [
    'payment_date' => 'date',
    ];

    public function items() {
        return $this->hasMany(ExpenseItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

}
