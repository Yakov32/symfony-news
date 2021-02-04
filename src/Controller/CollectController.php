<?php


namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Service\PostOnlineCollector;
use App\Service\PostParser;
use App\Service\PostMapper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\Tag;
use DateTimeInterface;


class CollectController
{
    public function __construct(PostOnlineCollector $onlineCollector, PostParser $postParser, PostMapper $postMapper)
    {
        $this->onlineCollector = $onlineCollector;
        $this->postParser = $postParser;
        $this->postMapper = $postMapper;
    }
    /**
     * @Route ("collect-news")
     */
    public function index(): Response
    {
        $collected_posts = $this->onlineCollector->collectPosts();

        $this->postParser->parsePosts($collected_posts);
        $posts = $this->postParser->getParsedPosts();

        $this->postMapper->mapData($posts);

        return new Response(print_r($collected_posts));
    }
}