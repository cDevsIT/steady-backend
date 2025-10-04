<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'balance',
        'status',
        'currency',
        'last_activity_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all transactions for the wallet.
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Get recent transactions.
     */
    public function recentTransactions($limit = 10)
    {
        return $this->transactions()->latest()->limit($limit)->get();
    }

    /**
     * Update wallet balance and record transaction.
     */
    public function updateBalance($amount, $type, $description = null, $reference = null, $createdBy = null)
    {
        $balanceBefore = $this->balance;
        $this->balance += $amount;
        $balanceAfter = $this->balance;
        $this->last_activity_at = now();
        $this->save();

        return $this->transactions()->create([
            'type' => $type,
            'amount' => abs($amount),
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'status' => 'Completed',
            'reference' => $reference,
            'description' => $description,
            'created_by' => $createdBy,
        ]);
    }

    /**
     * Freeze the wallet.
     */
    public function freeze()
    {
        $this->status = 'Frozen';
        $this->save();
    }

    /**
     * Unfreeze the wallet.
     */
    public function unfreeze()
    {
        $this->status = 'Active';
        $this->save();
    }

    /**
     * Check if wallet is frozen.
     */
    public function isFrozen()
    {
        return $this->status === 'Frozen';
    }

    /**
     * Get total deposits.
     */
    public function getTotalDeposits()
    {
        return $this->transactions()
            ->where('type', 'Deposit')
            ->where('status', 'Completed')
            ->sum('amount');
    }

    /**
     * Get total withdrawals.
     */
    public function getTotalWithdrawals()
    {
        return $this->transactions()
            ->where('type', 'Withdrawal')
            ->where('status', 'Completed')
            ->sum('amount');
    }

    /**
     * Get total transfers.
     */
    public function getTotalTransfers()
    {
        return $this->transactions()
            ->where('type', 'Transfer')
            ->where('status', 'Completed')
            ->sum('amount');
    }

    /**
     * Get total adjustments.
     */
    public function getTotalAdjustments()
    {
        return $this->transactions()
            ->where('type', 'Adjustment')
            ->where('status', 'Completed')
            ->sum('amount');
    }

    /**
     * Get total transaction fees.
     */
    public function getTotalFees()
    {
        return 0; // Placeholder for future implementation
    }
}

