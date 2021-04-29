<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\PostRepository;
use App\Service\HtmlParser;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Post;
use Yasha32\MessagerBundle\Service\MessageService;


class IndexController
{
    private $entityManager;
    private $twig;
    private $htmlParser;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig, HtmlParser $htmlParser, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->htmlParser = $htmlParser;
    }

    /**
     * @Route ("/")
     */
    public function index(Request $request): Response
    {
        $page = $request->query->get('page', 1);

        $postRepository = $this->entityManager->getRepository(Post::class);
        $tagRepository = $this->entityManager->getRepository(Tag::class);

        $popularTags = $tagRepository->findMostPopular();
        $pagination = $postRepository->findAllOrderedBy($page);

        $htmlContent = $this->twig->render(
            'index/index.html.twig',
            compact('pagination', 'popularTags'));

        return new Response($this->htmlParser->tagsToLinks($htmlContent));
    }
}