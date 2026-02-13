<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $fillable = [
        'organization_id',
        'department_id',
        'budget_id',
        'user_id',
        'amount',
        'description',
        'status',
        'approver_id',
        'disburser_id'
    ];

    public function budget() { return $this->belongsTo(Budget::class); }
    public function user() { return $this->belongsTo(User::class); } // Requester
    public function department() { return $this->belongsTo(Department::class); }
    public function approver() { return $this->belongsTo(User::class, 'approver_id'); }
    public function disburser() { return $this->belongsTo(User::class, 'disburser_id'); }
}
