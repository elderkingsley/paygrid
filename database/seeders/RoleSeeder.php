<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'requester',
            'approver',
            'disburser',
            'admin'
        ];

        foreach ($roles as $role) {
            // This checks if it exists first before trying to create it
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
    }
}
