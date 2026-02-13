<?php

use App\Models\Expense;
use Illuminate\Support\Facades\Route;
use App\Livewire\Vendors\VendorManager;
use App\Livewire\Expenses\RequestCenter;
use App\Livewire\Organization\KycSettings;
use App\Http\Controllers\WebhookController;
use App\Livewire\Payments\PaymentProcessor;
use App\Livewire\Departments\DepartmentManager;
use App\Livewire\ExpenseCategories\CategoryManager;
use Illuminate\Support\Facades\Http;
use App\Livewire\Admin\CreateUser;

Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
    // This maps the Livewire component directly to a URL
    Route::get('/admin/create-user', CreateUser::class)->name('admin.create-user');
    });

Route::post('/paystack/webhook', [WebhookController::class, 'handlePaystack']);

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

    Route::get('dashboard', function () {
    $organization = auth()->user()->organization;

    // Fetch live balance from Paystack
    $currentBalance = $organization->wallet_balance; // Use the DB column

    $totalSpent = \App\Models\Expense::where('organization_id', $organization->id)
        ->where('status', 'approved')
        ->whereMonth('created_at', now()->month)
        ->sum('total_amount');

    return view('dashboard', compact('organization', 'totalSpent', 'currentBalance'));
})->name('dashboard');

});

Route::get('/test-webhook', function () {
    $url = url('/paystack/webhook'); // Ensure this matches your webhook route
    $secret = config('services.paystack.secret');

    // Get a real customer code from your DB to test with
    $org = \App\Models\Organization::first();
    $customerCode = $org->paystack_customer_code ?? 'CUS_4nol7k83p1zfb0y';

    $payload = [
        'event' => 'charge.success',
        'data' => [
            'status' => 'success',
            'amount' => 500000, // 5000 Naira in kobo
            'reference' => 'test_ref_' . time(),
            'customer' => [
                'customer_code' => $customerCode
            ]
        ]
    ];

    $jsonPayload = json_encode($payload);
    $signature = hash_hmac('sha512', $jsonPayload, $secret);

    $response = Http::withHeaders([
        'x-paystack-signature' => $signature,
        'Content-Type' => 'application/json',
    ])->post($url, $payload);

    return [
        'Target Customer Code' => $customerCode,
        'Paystack Response' => $response->json(),
        'Status Code' => $response->status(),
    ];


});

/*
|--------------------------------------------------------------------------
| Auth System (Breeze/Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
