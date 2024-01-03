<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Like;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Dislike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function getThumbnailAttribute()
    {
       // return '/videos/' . $this->uid . '/' . $this->thumbnail_image;
        return '/videos/' . $this->uid . '/' . $this->uid . '.png';
    }

    public function getUploadedDateAttribute()
    {
        $d = new Carbon($this->created_at);

        return $d->toFormattedDateString();
    }


    public function getStreamThumbnailAttribute()
    {
        return '/videos/' . $this->uid . '/thumbs/' . $this->uid . '.png';
    }


    public function getStreamUrlAttribute()
    {
        return asset(
            '/videos/' . $this->uid . '/' . $this->uid . '.m3u8'
        );
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class); // channel_id
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }

    public function doesUserLikedVideo()
    {
        // Überprüfen, ob es Likes in der Collection gibt, bei denen 'user_id' mit der aktuellen Benutzer-ID übereinstimmt.
        return $this->likes->where('user_id', auth()->id())->isNotEmpty();

      //return $this->likes->where('user_id' , Auth()->id())->exists();

        // return (bool) $this->likes->where('user_id', $user->id)->count();
    }

    public function doesUserDislikedVideo()
    {

        // Überprüfen, ob es Likes in der Collection gibt, bei denen 'user_id' mit der aktuellen Benutzer-ID übereinstimmt.
        return $this->dislikes->where('user_id', auth()->id())->isNotEmpty();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('reply_id');
    }

    public function AllCommentsCount()
    {
        return $this->hasMany(Comment::class)->count();
    }


}
