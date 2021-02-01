<?php


namespace App\Controller;

use App\Service\NewsCollectorService;
use App\Service\NewsParserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CollectController
{
    /**
     * @Route ("collect-news")
     */
    public function index(NewsCollectorService $collectorService, NewsParserService $parserService): Response
    {
        $news = $collectorService->index();

        $parserService->parseAll($news);
        $posts = $parserService->getParsedPosts();

        $all_tags = [];

        foreach($posts as $post){
            $all_tags = array_merge($all_tags, $post['tags']);
        }

        $all_tags = array_unique($all_tags);
        //return new Response(print_r($news));
        return new Response(print_r($posts));
    }


    public function putDb(){

    }
}