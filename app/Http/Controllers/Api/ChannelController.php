<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
//        $user_id = Auth::user()->id;
        $user_id = 1;
        return Channel::where('user_id', $user_id)->where('is_visible', 1)->get();
    }

    public function channelsDefault()
    {
        return Channel::all();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Channel $channel
     * @return Channel
     */
    public function update($id, Request $request)
    {
        $channel = Channel::find($id);
        $channel->title       = $request['params']['title'];
        $channel->save();

        return $channel;
    }

    public function getVideos(Channel $channel)
    {
        return $channel->videos;
    }
}
