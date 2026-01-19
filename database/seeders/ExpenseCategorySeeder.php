<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;
use App\Models\Organization;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Get the first organization in your database
        $org = Organization::first();

        if (!$org) {
            $this->command->error("No Organization found! Please create an organization before seeding categories.");
            return;
        }

        $categories = [
            'Entertainment',
            'Transportation',
            'Internet',
            'Telephone',
            'Others'
        ];

        foreach ($categories as $category) {
            ExpenseCategory::firstOrCreate([
                'name' => $category,
                'organization_id' => $org->id // This fixes the Not Null violation
            ]);
        }
    }
}
