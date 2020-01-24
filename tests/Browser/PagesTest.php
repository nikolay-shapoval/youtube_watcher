<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\CreatesUser;
use App\Models\Channel;
use Tests\CreatesChannel;
use App\Models\Video;
use Tests\CreatesVideo;

class PagesTest extends DuskTestCase
{
    use CreatesUser, CreatesChannel, CreatesVideo;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testGuest()
    {
        echo(PHP_EOL . 'Testing Guest' . PHP_EOL);

        $this->browse(
            function (Browser $browser) {
                $browser->visit('/')
                    ->assertSee('Welcome to Youtube Watcher!');
            }
        );
    }

    public function testAuth()
    {
        echo(PHP_EOL . 'Testing Auth' . PHP_EOL);

        $this->browse(
            function (Browser $browser) {
                $user = factory(User::class)->create();
                $channel = factory(Channel::class)->create(['user_id' => $user->id]);
                $video = factory(Video::class)->create(['chanel_id' => $channel->id]);

                $browser
                    ->loginAs($user)
                    ->visit('/')
                    ->assertSee('Welcome to VUE App!');

                $browser
                    ->loginAs($user)
                    ->visit('/#/personal/')
                    ->pause(10000)
                    ->assertSee('Enter your channel*s URL');

                $browser
                    ->loginAs($user)
                    ->visit('/#/blogger/' . $channel->id)
                    ->pause(10000)
                    ->assertSee($channel->title);

                $browser
                    ->loginAs($user)
                    ->visit('/#/blogger/' . $channel->id . '/videos/')
                    ->pause(10000)
                    ->assertSee($video->title);

                $user->delete();
                $channel->delete();
                $video->delete();
            }
        );
    }
}
