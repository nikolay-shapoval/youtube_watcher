<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 12.09.2018
 * Time: 13:08
 */

namespace App\Services;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Config;

class YoutubeService
{
    const FEED_URL = '/subscription_manager.xml';

    public function fetchChannels()
    {
        $feed = simplexml_load_string(Storage::get('subscription_manager.xml'));

        foreach ($feed->body->outline->outline as $item) {
            $channel = simplexml_load_file($item->attributes()->xmlUrl);

            $channel_model        = new Channel();
            $channel_model->title = (string)$channel->title;
            $channel_model->description = '';
            $channel_model->url   = (string)$channel->author->uri;
            $channel_model->save();

            foreach ($channel->entry as $video) {
                $video_model            = new Video();
                $video_model->chanel_id = $channel_model->id;
                $video_model->title     = (string)$video->title;
                $video_model->url     = (string)$video->link->attributes()->href;
                $namespaces             = $video->getNamespaces(true);

                $video_model->description = (string)$video->children($namespaces['media'])->group->description;
                $video_model->image_url   = (string)$video->children($namespaces['media'])->group->thumbnail->attributes()->url;
                $video_model->save();
            }

        }

    }

    /**/
    public function getSubscriptionsById($channelId, $part = ['contentDetails', 'id', 'snippet', 'subscriberSnippet'])
    {
        $API_URL = 'https://www.googleapis.com/youtube/v3/subscriptions';
        $params = [
            'channelId' => $channelId,
            'part' => implode(', ', $part),
            'maxResults' => 40
        ];

        $apiData = $this->api_get($API_URL, $params);

        return $this->decodeMultiple($apiData);
    }

    /**
     * Using CURL to issue a GET request
     *
     * @param $url
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    public function api_get($url, $params)
    {
        //set the youtube key
        $params['key'] = \Illuminate\Support\Facades\Config::get('youtube.key');

        //boilerplates for CURL
        $tuCurl = curl_init();
        curl_setopt($tuCurl, CURLOPT_URL, $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params));
        if (strpos($url, 'https') === false) {
            curl_setopt($tuCurl, CURLOPT_PORT, 80);
        } else {
            curl_setopt($tuCurl, CURLOPT_PORT, 443);
        }

        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
        $tuData = curl_exec($tuCurl);
        if (curl_errno($tuCurl)) {
            return ['error' => curl_error($tuCurl)];
        }

        return $tuData;
    }

    /**
     * Decode the response from youtube, extract the multiple resource object.
     *
     * @param  string $apiData the api response from youtube
     * @throws \Exception
     * @return \StdClass  an Youtube resource object
     */
    public function decodeMultiple(&$apiData)
    {
        $resObj = json_decode($apiData);
        if (isset($resObj->error)) {
            $msg = "Error " . $resObj->error->code . " " . $resObj->error->message;
            if (isset($resObj->error->errors[0])) {
                $msg .= " : " . $resObj->error->errors[0]->reason;
            }

            return ['error' => $msg];
        } else {
            $itemsArray = $resObj->items;
            if (!is_array($itemsArray)) {
                return false;
            } else {
                return $itemsArray;
            }
        }
    }
}