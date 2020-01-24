<?php
/**
 * Created by PhpStorm.
 * User: Pyro338
 * Date: 20.11.2018
 * Time: 10:13
 */

namespace Tests;

use App\Models\Video;

trait CreatesVideo
{
    public function createVideo($attributes = [])
    {
        return factory(Video::class)->create($attributes);
    }
}