Project: Laravel Fintech Treasury System
Status: Infrastructure Ready | Infrastructure: Paystack | Tech Stack: Laravel 11, Livewire 3, PostgreSQL, Tailwind CSS.

1. Core Architecture Logic
Model: Single Merchant Pool with Virtual Ledgers.

Fund Holding: All real money resides in the primary Paystack Merchant Balance.

Sweeping: Manual Payouts are enabled in the Paystack Dashboard to prevent the 24-hour automatic sweep to a personal bank account.

Internal Ledger: The Laravel database acts as the "Receipt Book," tracking how much of the total Paystack balance belongs to each Organization/Department.

2. Database Schema (The Ledger)
We have modified the default setup to support financial data:

Organizations Table:

id: UUID (Primary Key).

paystack_customer_code: String (Links the Org to a Paystack Customer identity).

virtual_account_number: String (The Titan Trust/Wema NUBAN).

virtual_bank_name: String.

wallet_balance: Decimal (15,2), Default: 0.00.

Transactions Table:

id: BigInt.

organization_id: UUID (Foreign Key - matches Organizations).

amount: Decimal (15,2).

type: Enum ('credit', 'debit').

description: String.

reference: String (Unique, stores Paystack Transaction Reference).

3. Integration & Security
Webhooks: Endpoint api/paystack/webhook is configured.

Signature Verification: Uses x-paystack-signature header and HMAC SHA512 with the PAYSTACK_SECRET_KEY to prevent spoofing.

CSRF: The webhook route is exempted from CSRF protection in bootstrap/app.php.

Ngrok: Used for local testing to tunnel Paystack events to localhost:8000.

4. Components Built
WebhookController: Handles charge.success events, increments the wallet_balance, and creates Transaction logs.

WalletCard (Livewire): A real-time UI component that:

Displays ₦ balance.

Shows Virtual Account details (Account # and Bank).

Polls every 30 seconds for balance updates.

Lists the 5 most recent transactions.

5. Current Dashboard Layout
Grid System: A 12-column Tailwind grid.

Left (Col 4): Financial Status (Wallet Card + Outflow Stats).

Right (Col 8): Action Area (Expense List/Management).

How to Resume Operations
If the session clears, provide this prompt:

"We are building a Paystack-powered treasury app in Laravel. I have an organizations table with a UUID id and a wallet_balance. I have a Transaction model and a WebhookController that verifies signatures. We use a single Paystack balance with Manual Payouts. Please help me with [Next Task]."
