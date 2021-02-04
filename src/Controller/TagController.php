<?php


namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class TagController
{
    private $twig;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @Route ("/{tag}")
     */
    public function indexAction($tag):Response
    {
        $postRepository = $this->entityManager->getRepository(Post::class);

        $posts = $postRepository->findByTag($tag);
        $htmlContent = $this->twig->render('tag/index.html.twig', compact('tag', 'posts'));

        return new Response($htmlContent);
    }
}