<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'initial_price',
        'renewal_fee',
        'transfer_fee',
        'renewal_period',
        'purchase_type',
        'is_active',
        'is_renewable',
        'auto_renewal',
        'visible_on_funnel',
        'is_transferable',
        'requires_state_selection',
        'requires_state_fees',
        'is_for_address',
        'last_updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_renewable' => 'boolean',
        'auto_renewal' => 'boolean',
        'visible_on_funnel' => 'boolean',
        'is_transferable' => 'boolean',
        'requires_state_selection' => 'boolean',
        'requires_state_fees' => 'boolean',
        'is_for_address' => 'boolean',
        'initial_price' => 'decimal:2',
        'renewal_fee' => 'decimal:2',
        'transfer_fee' => 'decimal:2',
        'renewal_period' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function features()
    {
        return $this->hasMany(ServiceFeature::class);
    }

    public function forms()
    {
        return $this->hasMany(ServiceForm::class);
    }

    // Note: Orders relationship removed as orders table doesn't have service_id column
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    // Accessors
    public function getStatusAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    public function getVisibilityBadgeAttribute()
    {
        return $this->visible_on_funnel ? 'success' : 'warning';
    }

    public function getVisibilityTextAttribute()
    {
        return $this->visible_on_funnel ? 'Visible' : 'Hidden';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('visible_on_funnel', true);
    }

    public function scopeRenewable($query)
    {
        return $query->where('is_renewable', true);
    }

    public function scopeTransferable($query)
    {
        return $query->where('is_transferable', true);
    }

    // Helper methods (simplified for current database structure)
    public function getTotalValue()
    {
        return $this->initial_price;
    }

    public function getAveragePrice()
    {
        return $this->initial_price;
    }

    public function getRenewalValue()
    {
        return $this->renewal_fee;
    }
}
