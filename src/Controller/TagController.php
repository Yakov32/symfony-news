<?php


namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Service\HtmlParser;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexAction(string $tag, Request $request):Response
    {
        $page = $request->query->get('page', 1);

        $postRepository = $this->entityManager->getRepository(Post::class);
        $tagRepository = $this->entityManager->getRepository(Tag::class);

        $posts = $postRepository->findByTag($tag, $page);
        $popularTags = $tagRepository->findMostPopular();

        $htmlContent = $this->twig->render(
            'tag/index.html.twig',
            compact('tag', 'posts', 'popularTags'));

        return new Response($this->htmlParser->tagsToLinks($htmlContent));
    }
}