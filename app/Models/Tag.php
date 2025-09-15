<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    protected $fillable = ['title'];
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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function posts()
    {
        return $this->belongsToMany(Blog::class,'post_tags', 'tag_id', 'blog_id');
    }
}
