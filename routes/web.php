<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Vendors\VendorManager;
use App\Livewire\Expenses\RequestCenter;
use App\Livewire\Payments\PaymentProcessor;
use App\Livewire\Departments\DepartmentManager;
use App\Livewire\ExpenseCategories\CategoryManager;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (The App Shell)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Main Dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Profile Management
    Route::view('profile', 'profile')->name('profile');

    // Administration: Departments
    Route::get('/departments', DepartmentManager::class)->name('departments.index');

    // Administration: Categories
    Route::get('/categories', CategoryManager::class)->name('categories.index');

    Route::get('/vendors', VendorManager::class)->name('vendors.index');

    Route::get('/payments', PaymentProcessor::class)->name('payments.index');

    Route::get('/requests', RequestCenter::class)->name('requests.index');

    Route::get('/requests', \App\Livewire\Expenses\RequestCenter::class)->name('requests.index');

});

/*
|--------------------------------------------------------------------------
| Auth System (Breeze/Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
