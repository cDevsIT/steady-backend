<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'charge_id',
        'status',
        'payment_method',
        'receipt_url',
        'card_type',
        'amount',
        'player_name',
    ];

    public function getAttribute($key)
    {
        if ($key === 'created_at') {
            // Check if the timezone cookie exists
            $timezone = isset($_COOKIE['timezone']) ? $_COOKIE['timezone'] : config('app.timezone');
            return Carbon::parse(parent::getAttribute($key))
                ->timezone($timezone)
                ->format('Y-m-d H:i:s');
        }

        return parent::getAttribute($key);
    }
    public function order(){
        return $this->hasOne(Order::class);
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
