<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        Role::create(['name' => 'Org Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'Staff', 'guard_name' => 'web']);
        $this->call(RolesAndPermissionsSeeder::class);
    }

}
