<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
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
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFileNameAttribute()
    {
        if (!empty($this->attachment)) {
            return $this->generateFileName($this->attachment);
        }
        return  "";

    }
    public function generateFileName($path)
    {
        $filename = basename($path);
        $section = pathinfo($filename, PATHINFO_FILENAME);
        $formattedSection = preg_replace('/[_-]/', ' ', $section);
        $title = ucwords(strtolower($formattedSection));
        return $title;
    }
}
