<?php
/**
 * Created by PhpStorm.
 * User: Pyro338
 * Date: 20.11.2018
 * Time: 10:13
 */

namespace Tests;

use App\Models\Channel;

trait CreatesChannel
{
    public function createChannel($attributes = [])
    {
        return factory(Channel::class)->create($attributes);
    }
}