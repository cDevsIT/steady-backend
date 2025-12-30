<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'order_id',
        'company_id',
        'user_id',
        'transition_id',
        'order_date',
        'renewal_date',
        'service_type',
        'service_fee',
        'renewal_fee',
    ];

    protected $casts = [
        'order_date' => 'date',
        'renewal_date' => 'date',
        'service_fee' => 'decimal:2',
        'renewal_fee' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transition()
    {
        return $this->belongsTo(Transition::class, 'transition_id');
    }
}
