<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first 5 customers (role = 2)
        $users = User::where('role', 2)->take(5)->get();

        foreach ($users as $index => $user) {
            // Skip if wallet already exists
            if (Wallet::where('user_id', $user->id)->exists()) {
                continue;
            }

            // Create wallet with varying balances
            $balances = [500, 1000, 150, 750, 2000];
            $types = ['Personal', 'Business', 'Personal', 'Personal', 'Business'];
            $statuses = ['Active', 'Active', 'Active', 'Frozen', 'Active'];

            $wallet = Wallet::create([
                'user_id' => $user->id,
                'type' => $types[$index % 5],
                'balance' => $balances[$index % 5],
                'status' => $statuses[$index % 5],
                'currency' => 'USD',
                'last_activity_at' => now(),
            ]);

            // Create initial deposit transaction
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'Deposit',
                'amount' => $balances[$index % 5],
                'balance_before' => 0,
                'balance_after' => $balances[$index % 5],
                'status' => 'Completed',
                'reference' => 'INIT-' . strtoupper(uniqid()),
                'description' => 'Initial wallet balance',
                'created_by' => 1, // Admin user
            ]);

            $this->command->info("Created wallet for user: {$user->email} with balance: \${$balances[$index % 5]}");
        }

        $this->command->info('Wallet seeder completed successfully!');
    }
}

