<?php

use App\Models\Expense;
use Illuminate\Support\Facades\Route;
use App\Livewire\Vendors\VendorManager;
use App\Livewire\Expenses\RequestCenter;
use App\Livewire\Organization\KycSettings;
use App\Livewire\Payments\PaymentProcessor;
use App\Livewire\Departments\DepartmentManager;
use App\Livewire\ExpenseCategories\CategoryManager;

Route::middleware(['auth', 'verified'])->group(function () {

    // Main Dashboard (The updated version above)
    Route::get('dashboard', function () {
        $organization = auth()->user()->organization;
        $totalSpent = Expense::where('organization_id', $organization->id)
            ->where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        return view('dashboard', compact('organization', 'totalSpent'));
    })->name('dashboard');

    // Profile Management
    Route::view('profile', 'profile')->name('profile');

    // Business Logic Routes
    Route::get('/departments', DepartmentManager::class)->name('departments.index');
    Route::get('/categories', CategoryManager::class)->name('categories.index');
    Route::get('/vendors', VendorManager::class)->name('vendors.index');
    Route::get('/payments', PaymentProcessor::class)->name('payments.index');
    Route::get('/requests', RequestCenter::class)->name('requests.index');

    // Treasury & Sub-accounts
    Route::get('/settings/treasury', KycSettings::class)->name('settings.treasury');
    Route::get('/settings/departments', \App\Livewire\Organization\DepartmentManager::class)->name('settings.departments');

});

/*
|--------------------------------------------------------------------------
| Auth System (Breeze/Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
