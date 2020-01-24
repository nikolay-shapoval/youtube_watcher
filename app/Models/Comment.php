<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 12.09.2018
 * Time: 13:02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $attributes = [
        'text' => '',
    ];

    protected $fillable = [
        'type', 'text', 'item_id', 'is_visible'
    ];
}
