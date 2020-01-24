<?php

use Faker\Generator as Faker;

$factory->define(
    App\Models\Video::class,
    function (Faker $faker) {
        return [
            'title'       => $faker->name,
            'url'         => 'https://www.youtube.com/watch?v=XV73L7UTJcA',
            'image_url'   => 'https://i.ytimg.com/vi/7jCFwsgCK8o/maxresdefault.jpg',
            'description' => $faker->sentence,
            'is_visible'  => 1,
            'video_id'    => 'XV73L7UTJcA'
        ];
    }
);
