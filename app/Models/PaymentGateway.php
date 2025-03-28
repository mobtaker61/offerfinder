<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentGateway extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'display_name',
        'description',
        'is_active',
        'is_test_mode',
        'configuration',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'configuration' => 'json',
    ];

    /**
     * Get the payment methods for this gateway.
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Scope a query to only include active gateways.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the test API key from configuration.
     */
    public function getTestApiKeyAttribute()
    {
        if (is_array($this->configuration) && isset($this->configuration['test_api_key'])) {
            return $this->configuration['test_api_key'];
        }
        return null;
    }

    /**
     * Get the live API key from configuration.
     */
    public function getLiveApiKeyAttribute()
    {
        if (is_array($this->configuration) && isset($this->configuration['live_api_key'])) {
            return $this->configuration['live_api_key'];
        }
        return null;
    }

    /**
     * Get the current API key based on mode.
     */
    public function getCurrentApiKeyAttribute()
    {
        return $this->is_test_mode ? $this->test_api_key : $this->live_api_key;
    }
}
