<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Store a newly created wallet.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:Personal,Business',
            'initial_balance' => 'nullable|numeric|min:0',
            'currency' => 'required|string|max:3',
            'status' => 'required|in:Active,Frozen',
        ]);

        DB::beginTransaction();
        try {
            // Check if user already has a wallet
            $existingWallet = Wallet::where('user_id', $request->user_id)->first();

            if ($existingWallet) {
                return back()->with('error', 'User already has a wallet.');
            }

            // Create the wallet
            $wallet = Wallet::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'balance' => $request->initial_balance ?? 0,
                'currency' => $request->currency,
                'status' => $request->status,
                'last_activity_at' => now(),
            ]);

            // If initial balance > 0, create a transaction record
            if ($request->initial_balance && $request->initial_balance > 0) {
                $wallet->transactions()->create([
                    'type' => 'Deposit',
                    'amount' => $request->initial_balance,
                    'balance_before' => 0,
                    'balance_after' => $request->initial_balance,
                    'status' => 'Completed',
                    'reference' => 'INIT-' . strtoupper(uniqid()),
                    'description' => 'Initial balance when wallet was created',
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.wallets.index')->with('success', 'Wallet created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create wallet: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of wallets.
     */
    public function index(Request $request)
    {
        session(['lsbm' => 'wallets', 'lsbsm' => 'wallets']);

        // Build query
        $query = Wallet::with('user');

        // Apply filters
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                    ->orWhere('last_name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_balance')) {
            $query->where('balance', '>=', $request->min_balance);
        }

        if ($request->filled('max_balance')) {
            $query->where('balance', '<=', $request->max_balance);
        }

        // Get statistics
        $totalWallets = Wallet::count();
        $activeWallets = Wallet::where('status', 'Active')->count();
        $frozenWallets = Wallet::where('status', 'Frozen')->count();
        $totalBalance = Wallet::where('status', 'Active')->sum('balance');

        // Get paginated wallets
        $wallets = $query->latest()->paginate(15);

        // Handle CSV export
        if ($request->submit_type === 'csv') {
            return $this->exportCSV($query->get());
        }

        return view('admin.wallets.index', compact(
            'wallets',
            'totalWallets',
            'activeWallets',
            'frozenWallets',
            'totalBalance'
        ));
    }

    /**
     * Show wallet details.
     */
    public function show($id)
    {
        session(['lsbm' => 'wallets', 'lsbsm' => 'wallets']);

        $wallet = Wallet::with('user')->findOrFail($id);
        
        // Get transaction statistics
        $totalTransactions = $wallet->transactions()->count();
        $totalTransfers = $wallet->transactions()->where('type', 'Transfer')->count();
        $totalDeposits = $wallet->getTotalDeposits();
        $totalWithdrawals = $wallet->getTotalWithdrawals();
        $totalAdjustments = $wallet->getTotalAdjustments();
        $totalFees = $wallet->getTotalFees();
        
        // Get recent transactions
        $recentTransactions = $wallet->transactions()
            ->with('creator')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.wallets.show', compact(
            'wallet',
            'totalTransactions',
            'totalTransfers',
            'totalDeposits',
            'totalWithdrawals',
            'totalAdjustments',
            'totalFees',
            'recentTransactions'
        ));
    }

    /**
     * Show wallet transactions.
     */
    public function transactions($id, Request $request)
    {
        session(['lsbm' => 'wallets', 'lsbsm' => 'wallets']);

        $wallet = Wallet::with('user')->findOrFail($id);
        
        $query = $wallet->transactions()->with('creator');

        // Apply filters
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $transactions = $query->latest()->paginate(20);

        return view('admin.wallets.transactions', compact('wallet', 'transactions'));
    }

    /**
     * Adjust wallet balance.
     */
    public function adjustBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:add,subtract',
            'description' => 'nullable|string|max:500',
        ]);

        $wallet = Wallet::findOrFail($id);

        if ($wallet->isFrozen()) {
            return back()->with('error', 'Cannot adjust balance of a frozen wallet.');
        }

        $amount = $request->type === 'add' ? abs($request->amount) : -abs($request->amount);
        
        DB::beginTransaction();
        try {
            $wallet->updateBalance(
                $amount,
                'Adjustment',
                $request->description ?? ($request->type === 'add' ? 'Balance added by admin' : 'Balance deducted by admin'),
                'ADJ-' . strtoupper(uniqid()),
                auth()->id()
            );

            DB::commit();
            return back()->with('success', 'Wallet balance adjusted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to adjust wallet balance: ' . $e->getMessage());
        }
    }

    /**
     * Update wallet details.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:Personal,Business',
            'status' => 'required|in:Active,Frozen',
        ]);

        $wallet = Wallet::findOrFail($id);

        $wallet->update([
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Wallet updated successfully.');
    }

    /**
     * Toggle wallet freeze status.
     */
    public function toggleFreeze($id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet->isFrozen()) {
            $wallet->unfreeze();
            $message = 'Wallet unfrozen successfully.';
        } else {
            $wallet->freeze();
            $message = 'Wallet frozen successfully.';
        }

        return back()->with('success', $message);
    }

    /**
     * Show activity log.
     */
    public function activityLog($id)
    {
        session(['lsbm' => 'wallets', 'lsbsm' => 'wallets']);

        $wallet = Wallet::with('user')->findOrFail($id);
        
        $activities = $wallet->transactions()
            ->with('creator')
            ->latest()
            ->paginate(20);

        return view('admin.wallets.activity-log', compact('wallet', 'activities'));
    }

    /**
     * Export wallets to CSV.
     */
    private function exportCSV($wallets)
    {
        $filename = 'wallets_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($wallets) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'User Name',
                'Email',
                'Type',
                'Balance',
                'Status',
                'Currency',
                'Created At',
                'Last Activity'
            ]);

            // Add data rows
            foreach ($wallets as $wallet) {
                fputcsv($file, [
                    $wallet->id,
                    $wallet->user->first_name . ' ' . $wallet->user->last_name,
                    $wallet->user->email,
                    $wallet->type,
                    $wallet->balance,
                    $wallet->status,
                    $wallet->currency,
                    $wallet->created_at->format('Y-m-d H:i:s'),
                    $wallet->last_activity_at ? $wallet->last_activity_at->format('Y-m-d H:i:s') : 'No activity',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

