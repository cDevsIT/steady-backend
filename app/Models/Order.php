<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
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
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function customer (){
        return $this->belongsTo(User::class,'user_id');
    }
    public function transition (){
        return $this->belongsTo(Transition::class,'transition_id');
    }
    public function user (){
        return $this->belongsTo(User::class,'user_id');
    }
    public function state (){
        return $this->belongsTo(StateFee::class,'state_id');
    }
}
