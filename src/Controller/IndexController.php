<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Post;
use App\Entity\Tag;

class IndexController
{
    private $entityManager;
    private $paginator;
    private $twig;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->twig = $twig;
    }

    /**
     * @Route ("/")
     */
    public function index(Request $request): Response
    {
        $page = $request->query->get('page', 1);

        $postRepository = $this->entityManager->getRepository(Post::class);
        //$posts = $postRepository->findAllOrderedBy();
        $pagination = $postRepository->findAllOrderedBy($this->paginator, $page);
        //$htmlContent = $this->twig->render('index/index.html.twig', compact('posts'));
        $htmlContent = $this->twig->render('index/index.html.twig', compact('pagination'));
        return new Response($htmlContent);
    }
}