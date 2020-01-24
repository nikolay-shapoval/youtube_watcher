<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\UserController;
use App\User;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function YoutubeAuth()
    {
        $url           = 'https://accounts.google.com/o/oauth2/v2/auth';
        $client_id     = '539397549109-bbnsmg6erkruin76v23kbbii02v2udau.apps.googleusercontent.com';
        $redirect_uri  = 'http://localhost:8000/youtube/callback';
        $scope         = 'https://www.googleapis.com/auth/youtube';
        $response_type = 'code';

        return redirect(
            $url .
            '?client_id=' . $client_id .
            '&redirect_uri=' . $redirect_uri .
            '&scope=' . $scope .
            '&response_type=' . $response_type
        );
    }

    public function YoutubeCallback(Request $request)
    {
        $client_id     = '539397549109-bbnsmg6erkruin76v23kbbii02v2udau.apps.googleusercontent.com';
        $redirect_uri  = 'http://localhost:8000/youtube/callback';
        $url           = "https://www.googleapis.com/oauth2/v4/token";
        $client_secret = 'YeqXarUX0kmEhou4CEbmXhRy';

        try {
            $code      = $request->code;
            $post_data = array(
                "code"          => $code,
                "client_id"     => $client_id,
                "client_secret" => $client_secret,
                'redirect_uri'  => $redirect_uri,
                'grant_type'    => 'authorization_code'
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            $token_response = curl_exec($curl);
            curl_close($curl);

            if ($token = json_decode($token_response)->access_token) {
                $url  = 'https://www.googleapis.com/youtube/v3/channels?access_token=' . $token . '&part=snippet&mine=true';
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $api_response = curl_exec($curl);
                curl_close($curl);

                $user = $this->YoutubeCreateOrGetUser(json_decode($api_response));
                auth()->login($user);
                try{
                    UserController::getSubscribes($user->id);
                } catch (\Exception $e) {
                    return redirect('/');
                }

                return redirect()->to('/');
            } else {
                return redirect('/');
            }
        } catch (\Exception $e) {
            return redirect('/');
        }
    }

    private function YoutubeCreateOrGetUser($request)
    {
        $user_data = $request->items[0];
        $user = User::whereGoogleId($user_data->id)->first();

        if (!$user) {
            $user = User::create(
                [
                    'email'     => $user_data->id . '@pyro338.ru',
                    'name'      => $user_data->snippet->title,
                    'google_id' => $user_data->id,
                    'feed_url'  => 'https://www.youtube.com/channel/' . $user_data->id
                ]
            );
        }

        $user->session_state = bcrypt(time());
        $user->save();

        return $user;
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}