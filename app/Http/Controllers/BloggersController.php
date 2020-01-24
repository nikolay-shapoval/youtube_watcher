<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 12.09.2018
 * Time: 13:17
 */

namespace App\Http\Controllers;

class BloggersController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        return view('welcome');
    }

    public function channelsListByUsername($service, $part, $params)
    {
        $params   = array_filter($params);
        $response = $service->channels->listChannels(
            $part,
            $params
        );

        $description = sprintf(
            'This channel\'s ID is %s. Its title is %s, and it has %s views.',
            $response['items'][0]['id'],
            $response['items'][0]['snippet']['title'],
            $response['items'][0]['statistics']['viewCount']
        );
        print $description . "\n";
    }
}