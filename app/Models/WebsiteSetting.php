<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;
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
}
