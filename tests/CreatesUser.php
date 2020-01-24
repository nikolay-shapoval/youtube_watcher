<?php
/**
 * Created by PhpStorm.
 * User: Pyro338
 * Date: 20.11.2018
 * Time: 9:46
 */

namespace Tests;

use App\User;

trait CreatesUser
{
    public function createUser($attributes = [])
    {
        return factory(User::class)->create($attributes);
    }
}