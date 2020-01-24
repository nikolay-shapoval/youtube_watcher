<?php
/**
 * Created by PhpStorm.
 * User: Pyro338
 * Date: 16.10.2018
 * Time: 13:41
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name', 'email', 'feed_url'
    ];
}