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
        $parsed_posts = $parserService->getParsedPosts();

        //return new Response(print_r($news));
        return new Response(print_r($parsed_posts));
    }
}