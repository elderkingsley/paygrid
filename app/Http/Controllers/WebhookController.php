<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function handlePaystack(Request $request)
    {
        // 1. Validate the Signature (Security First)
        $paystackSignature = $request->header('x-paystack-signature');
        $secretKey = config('services.paystack.secret');

        if (!$paystackSignature || $paystackSignature !== hash_hmac('sha512', $request->getContent(), $secretKey)) {
            Log::warning('Paystack Webhook: Invalid signature attempt.');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? null;
        $data = $payload['data'] ?? null;

        // 2. Process only successful charges
        if ($event === 'charge.success' && ($data['status'] === 'success')) {
            $amountInNaira = $data['amount'] / 100;
            $customerCode = $data['customer']['customer_code'];

            // Find the organization
            $organization = Organization::where('paystack_customer_code', $customerCode)->first();

            if (!$organization) {
                Log::error("Paystack Webhook: No organization found for customer code: " . $customerCode);
                return response()->json(['message' => 'Organization not found'], 404);
            }

            // 3. Update Balance and Record Transaction Atomically
            try {
                DB::transaction(function () use ($organization, $amountInNaira, $data) {
                    $organization->increment('wallet_balance', $amountInNaira);

                    Transaction::create([
                        'organization_id' => $organization->id,
                        'amount'          => $amountInNaira,
                        'type'            => 'credit',
                        'description'     => 'Wallet Funding (Paystack)',
                        'reference'       => $data['reference']
                    ]);
                });

                return response()->json(['status' => 'success'], 200);

            } catch (\Exception $e) {
                Log::error("Paystack Webhook: Database error - " . $e->getMessage());
                return response()->json(['message' => 'Internal Server Error'], 500);
            }
        }

        // Acknowledge other events but do nothing
        return response()->json(['status' => 'event ignored'], 200);
    }
}
