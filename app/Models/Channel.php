<?php

namespace App\Models;

use App\Models\User;
use App\Models\Video;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function user()
    {
        return $this->belongsTo(User::class); // user_id
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscribers()
    {
        return $this->subscriptions->count();
    } // subscribers


    public function getPictureAttribute()
    {
        if ($this->image) {
            return '/images/' . $this->image;
        } else {
            return '/images/default.png';
        }
    }
}
