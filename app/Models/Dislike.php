<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dislike extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
