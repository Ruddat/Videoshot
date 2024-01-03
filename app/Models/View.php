<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class View extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'video_id'];

    public function video()
{
    return $this->belongsTo(Video::class, 'video_id');
}


}
