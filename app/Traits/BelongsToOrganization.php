<?php

namespace App\Traits;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToOrganization
{
    protected static function bootBelongsToOrganization(): void
    {
        static::addGlobalScope(new OrganizationScope);

        static::creating(function ($model) {
            if (Auth::hasUser() && ! $model->organization_id) {
                $model->organization_id = Auth::user()->organization_id;
            }
        });
    }
}
