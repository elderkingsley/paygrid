<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions
        $permissions = [
            'create-request',
            'approve-request',
            'disburse-funds',
            'manage-budgets'
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        // 2. Create Roles and Assign Permissions

        // Staff: Only requests
        \Spatie\Permission\Models\Role::create(['name' => 'staff'])
            ->givePermissionTo(['create-request']);

        // Manager: Requests + Approvals
        \Spatie\Permission\Models\Role::create(['name' => 'manager'])
            ->givePermissionTo(['create-request', 'approve-request']);

        // Finance: Can Disburse
        \Spatie\Permission\Models\Role::create(['name' => 'finance'])
            ->givePermissionTo(['disburse-funds']);

        // Admin: Can do EVERYTHING
        \Spatie\Permission\Models\Role::create(['name' => 'admin'])
            ->givePermissionTo(\Spatie\Permission\Models\Permission::all());
    }

    /**
     * Run the database seeds.
     */
}
