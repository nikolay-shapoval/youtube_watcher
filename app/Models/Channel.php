<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Channel extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'is_visible',
    ];

    protected $appends = [
        'photo_link',
        'comments'
    ];

    public function getPhotoLinkAttribute()
    {
        return $this->file_id ? '/api/files/' . $this->file_id . '/download/' : '/img/photo.jpg';
    }

    public function getCommentsAttribute()
    {
        return $this->comments()->get();
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'chanel_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'item_id', 'id');
    }

    public function getPublishedAtAttribute($published_at){

        return Carbon::parse($published_at)->format('d.m.Y H:m');
    }
}