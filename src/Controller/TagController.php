<?php


namespace App\Controller;

use App\Entity\Post;
use App\Service\HtmlParser;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class TagController
{
    private $entityManager;
    private $htmlParser;
    private $twig;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager, HtmlParser $htmlParser)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->htmlParser = $htmlParser;
    }

    /**
     * @Route ("/{tag}")
     */
    public function indexAction(string $tag):Response
    {
        $postRepository = $this->entityManager->getRepository(Post::class);

        $posts = $postRepository->findByTag($tag);

        $htmlContent = $this->twig->render('tag/index.html.twig', compact('tag', 'posts'));

        return new Response($this->htmlParser->tagsToLinks($htmlContent));
    }
}