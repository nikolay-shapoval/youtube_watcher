<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\User;
use Tests\TestCase;
use Tests\CreatesUser;
use Tests\CreatesChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class BackendTest extends TestCase
{
    use CreatesUser, CreatesChannel;

    public function testGuest()
    {
        echo('Testing Guest' . PHP_EOL);

        $response = $this->get('/');
        $response->assertStatus(302);
    }

    public function testAuth()
    {
        echo('Testing Auth' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    public function testChannelsIndex()
    {
        echo('Testing Channels index' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);

        $response = $this->actingAs($user)->json('GET', '/api/channels/');
        $response->assertStatus(200);
    }

    public function testChannelsChannelsDefault()
    {
        echo('Testing Channels channelsDefault' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);

        $response = $this->actingAs($user)->json('POST', '/api/channels/channelsDefault/');
        $response->assertStatus(200);
    }

    public function testChannelsUpdate()
    {
        echo('Testing Channels update' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);
        $channel = factory(Channel::class)->create();
        $params['params'] = ['title' => 'Lorem Ipsum'];

        $response = $this->actingAs($user)->json('PUT', '/api/channels/' . $channel->id, $params);
        $response->assertStatus(200);
    }

    public function testChannelsGetVideos()
    {
        echo('Testing Channels getVideos' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);
        $channel = factory(Channel::class)->create();

        $response = $this->actingAs($user)->json('POST', '/api/channels/' . $channel->id . '/getVideos/');
        $response->assertStatus(200);
    }

    public function testComments()
    {
        echo('Testing Comments' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);
        $channel = factory(Channel::class)->create();
        $params['params']  = [
            'type'       => 'comment',
            'text'       => 'Lorem Ipsum',
            'item_id'    => $channel->id,
            'is_visible' => 1
        ];

        $response = $this->actingAs($user)->json('POST', '/api/comments/', $params);
        $response->assertStatus(201);
    }

    public function testUsersIndex()
    {
        echo('Testing Users index' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);

        $response = $this->actingAs($user)->json('GET', '/api/users/');
        $response->assertStatus(200);
    }

    public function testUsersUpdate()
    {
        echo('Testing Users update' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);
        $params['params'] = ['feed_url' => 'https://www.youtube.com/channel/UC6yrbPgLFyq9IS9ICVa9tyw'];

        $response = $this->actingAs($user)->json('PUT', '/api/users/' . $user->id, $params);
        $response->assertStatus(200);
    }

    public function testUsersGetSubscribes()
    {
        echo('Testing Users getSubscribes' . PHP_EOL);

        $user = factory(User::class)->create();
        auth()->login($user);

        $response = $this->actingAs($user)->json('POST', '/api/users/' . $user->id . '/getSubscribes/');
        $response->assertStatus(200);
    }
}
