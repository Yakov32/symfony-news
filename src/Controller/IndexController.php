<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Post;
use App\Entity\Tag;

class IndexController
{
    private $entityManager;
    private $twig;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @Route ("/")
     */
    public function index(Request $request): Response
    {
        $page = $request->query->get('page');

        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findAllOrderedBy();

        $htmlContent = $this->twig->render('index/index.html.twig', compact('posts'));

        return new Response($htmlContent);
    }
}