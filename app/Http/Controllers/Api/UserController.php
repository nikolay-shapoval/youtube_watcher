<?php

namespace App\Http\Controllers\Api;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Alaouy\Youtube\Facades\Youtube;
use App\Services\YoutubeService;
use Mockery\Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user_id = Auth::user()->id;
        $user_id = 1;

        return User::find($user_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user           = User::find($id);
        $user->feed_url = $request['params']['feed_url'];
        $user->save();

        return $user;
    }

    public static function getSubscribes($id)
    {
        $user        = User::find($id);
        $user->state = $user->session_state;
        $user->save();

        if (!$user->feed_url || trim($user->feed_url) == '') {
            return json_encode(['error' => 'no_feed_url']);
        } else {
            try {
                $channel_id     = explode('/', $user->feed_url)[4];
                $youtubeservice = new YoutubeService();
                if ($error = isset($youtubeservice->getSubscriptionsById($channel_id)['error'])) {
                    return json_encode(['error' => $error]);
                }
                $subscribations      = $youtubeservice->getSubscriptionsById($channel_id);
                $user_subscribations = Channel::where('user_id', $user->id)->get();
                foreach ($user_subscribations as $subscribation) {
                    $subscribation->is_visible = 0;
                    $subscribation->save();
                }
                foreach ($subscribations as $subscribation) {
                    $subscribation_id  = $subscribation->snippet->resourceId->channelId;
                    $subscribation_url = 'https://www.youtube.com/channel/' . $subscribation_id;
                    if ($channel = Channel::where('url', $subscribation_url)->where('user_id', $user->id)->first()) {
                        $channel->title        = $subscribation->snippet->title;
                        $channel->description  = $subscribation->snippet->description;
                        $channel->avatar_url   = $subscribation->snippet->thumbnails->medium->url;
                        $channel->published_at = $subscribation->snippet->publishedAt;
                        $channel->is_visible   = 1;
                        $channel->save();
                    } else {
                        $channel               = new Channel;
                        $channel->title        = $subscribation->snippet->title;
                        $channel->url          = $subscribation_url;
                        $channel->description  = $subscribation->snippet->description;
                        $channel->avatar_url   = $subscribation->snippet->thumbnails->medium->url;
                        $channel->published_at = $subscribation->snippet->publishedAt;
                        $channel->is_visible   = 1;
                        $channel->user_id      = $user->id;
                        $channel->save();
                    }
                    $videoList = Youtube::listChannelVideos($subscribation_id, 40);
                    if (isset($videoList) && is_array($videoList) && !empty($videoList)) {
                        foreach ($videoList as $videoItem) {
                            $video_url = 'https://www.youtube.com/watch?v=' . $videoItem->id->videoId;
                            if (!$video = Video::where('url', $video_url)->first()) {
                                $video              = new Video;
                                $video->chanel_id   = $channel->id;
                                $video->title       = $videoItem->snippet->title;
                                $video->url         = $video_url;
                                $video->image_url   = $videoItem->snippet->thumbnails->default->url;
                                $video->description = $videoItem->snippet->description;
                                $video->video_id    = $videoItem->id->videoId;
                                $video->save();
                            }
                        }
                    }
                }
                $channels = Channel::where('user_id', $user->id)->where('is_visible', 1)->get();

                return json_encode(['success' => $channels]);
            } catch (Exception $e) {
                return json_encode(['error' => $e->getMessage()]);
            }
        }


    }
}
