<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Organization extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'virtual_account_number',
        'virtual_bank_name',
        'virtual_account_name',
        'kyc_verified',
        'slug'];

        public function users()
    {
        return $this->hasMany(User::class);
    }
}
