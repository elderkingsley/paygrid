<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Add this array to allow the WebhookController to save these fields
    protected $fillable = [
        'organization_id',
        'amount',
        'type',
        'description',
        'reference'
    ];

    /**
     * Relationship to the organization
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
