<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingSchema extends Model
{
    use HasFactory;

    protected $table = 'settings_schema';

    protected $fillable = [
        'key',
        'label',
        'description',
        'group',
        'data_type',
        'options',
        'default_value',
        'is_required',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function values()
    {
        return $this->hasMany(SettingValue::class);
    }

    public function activeValue()
    {
        return $this->hasOne(SettingValue::class)->where('is_active', true);
    }

    public function getOptionsArrayAttribute()
    {
        if ($this->options && $this->data_type === 'select') {
            return json_decode($this->options, true) ?? [];
        }
        return [];
    }

    public function getFormattedValueAttribute()
    {
        $value = $this->activeValue?->value ?? $this->default_value;

        switch($this->data_type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'array':
            case 'object':
                return json_decode($value, true) ?? ($this->data_type === 'array' ? [] : new \stdClass());
            default:
                return $value;
        }
    }
}
