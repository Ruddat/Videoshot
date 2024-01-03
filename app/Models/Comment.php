<?php

namespace App\Models;

use App\Models\User;
use App\Models\Video;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function scopeLatesFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id' , 'id');
    }


    public function repliesCount()
    {
        return $this->replies->count();
    }
}
