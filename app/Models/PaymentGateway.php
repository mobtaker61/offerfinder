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
        'display_name',
        'code',
        'description',
        'configuration',
        'is_active',
        'is_test_mode'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'configuration' => 'json',
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean'
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

    /**
     * Check if this gateway is Ziina
     */
    public function isZiina()
    {
        return $this->code === 'ziina';
    }

    /**
     * Get the API base URL based on test mode
     */
    public function getApiUrl()
    {
        // Ziina uses the same API for both test and live mode
        if ($this->isZiina()) {
            return 'https://api-v2.ziina.com/api';
        }
        
        return null;
    }
}
