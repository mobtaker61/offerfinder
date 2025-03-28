<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total_deposits',
        'total_withdrawals',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the wallet.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }
    
    /**
     * Get the total deposits.
     *
     * @return float
     */
    public function getTotalDepositsAttribute()
    {
        return $this->transactions()
            ->where('amount', '>', 0)
            ->where('status', 'completed')
            ->sum('amount');
    }
    
    /**
     * Get the total withdrawals.
     *
     * @return float
     */
    public function getTotalWithdrawalsAttribute()
    {
        return abs($this->transactions()
            ->where('amount', '<', 0)
            ->where('status', 'completed')
            ->sum('amount'));
    }
}
