<?php


namespace App\Service;


use Abraham\TwitterOAuth\TwitterOAuth;

class PostOnlineCollector
{
    private $twitterApiKeys;
    private $connectionParams;

    public function __construct(array $twitterApiKeys, array $connectionParams)
    {
        //Vars autowired from services.yaml and .env.local files
        $this->twitterApiKeys = $twitterApiKeys;
        $this->connectionParams = $connectionParams;
    }
    public function collectPosts()
    {
        $connection = new TwitterOAuth(
            $this->twitterApiKeys['twitterConsumerKey'],
            $this->twitterApiKeys['twitterConsumerSecret'],
            $this->twitterApiKeys['twitterAccessToken'],
            $this->twitterApiKeys['twitterAccessTokenSecret']
        );

        $statuses = $connection->get(
            $this->connectionParams['path'],
            $this->connectionParams['params']);

        return $statuses;
    }
}