<?php

namespace App\Models;

use App\Traits\BelongsToOrganization; // Your multi-tenant trait
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasUuids, BelongsToOrganization;

    protected $fillable = ['name', 'code', 'organization_id'];
}
