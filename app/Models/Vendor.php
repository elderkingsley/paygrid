<?php

namespace App\Models;

use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory, HasUuids, BelongsToOrganization;
    protected $fillable = [
        'name',
        'bank_name',
        'account_number',
        'account_name',
        'organization_id',
    ];
}
