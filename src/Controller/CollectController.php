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

        return new Response(print_r($posts));
    }

    /*public function putDb(array $posts)
    {
        foreach($posts as $post){
            if(null !== $this->postRepository->find($post->id)){continue;}

            $post_entity = new Post();

            $post_entity->setId($post->id);
            $post_entity->setText($post->text);
            $post_entity->setPublishedAt(new \DateTime($post->published_at));

            $this->entityManager->persist($post_entity);

            //Парсим теги с каждого поста.
            foreach($post->tags as $tag){

                if (null !== $this->tagRepository->find($tag)){continue;}

                $tag_entity = new Tag();
                $tag_entity->setName($tag);
                $this->entityManager->persist($tag_entity);
            }
        }
            $this->entityManager->flush();

    }*/
}