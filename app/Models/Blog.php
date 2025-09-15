<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;

    protected $fillable = ['title', 'content', 'description'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'tag_id', 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'addedBy');
    }
}
