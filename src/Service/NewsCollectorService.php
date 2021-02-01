<?php


namespace App\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Component\HttpFoundation\Response;

class NewsCollectorService
{
    public function index(): array
    {
        $twitter_app_consumer_key = 'taTWgJe9JVBU9XXFu7zAK1JFX';
        $twitter_app_consumer_secret = 'EeyNv6jb36q0SWUNRpeJLFMS3pOqqzs24ZvuGki1foijgoG49W';
        $twitter_app_access_token = '97639832-Z5o8XZi8dcUTpeUBfpcndD7MOnxT7iwkI7QeHJlDm';
        $twitter_app_access_token_secret = 'GzFlBECCLKx8xSK4kkfZguYFHGvSsZEPWIBTn1kEcgIXr';

        $connection = new TwitterOAuth(
            $twitter_app_consumer_key,
            $twitter_app_consumer_secret,
            $twitter_app_access_token,
            $twitter_app_access_token_secret);

        $statuses = $connection->get("statuses/user_timeline", array('count' => 20, 'exclude_replies' => false, 'screen_name' => 'thenewshooked'));

        return $statuses;
    }
}