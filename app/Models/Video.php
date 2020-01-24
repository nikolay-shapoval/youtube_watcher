<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $attributes = [
        'description' => '',
    ];

    protected $fillable = [
        'chanel_id', 'title', 'url', 'image_url', 'description', 'is_visible',
    ];

    protected $appends = [
        'embed_link'
    ];

    public function getEmbedLinkAttribute()
    {
        if (isset(explode('=', $this->url)[1])){
            return 'https://www.youtube.com/embed/' . explode('=', $this->url)[1];
        } else {
            return 'https://www.youtube.com/embed/';
        }
    }
}
