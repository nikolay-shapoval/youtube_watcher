<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Channel::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'url' => 'https://www.youtube.com/channel/UC6yrbPgLFyq9IS9ICVa9tyw',
        'description' => $faker->sentence,
        'is_visible' => 1,
        'user_id' => 1,
        'avatar_url' => 'https://yt3.ggpht.com/-M2uBw31opaY/AAAAAAAAAAI/AAAAAAAAAAA/5n81IoLh5yQ/s240-c-k-no-mo-rj-c0xffffff/photo.jpg'
    ];
});
