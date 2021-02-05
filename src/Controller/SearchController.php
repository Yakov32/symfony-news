<?php


namespace App\Controller;

use App\Entity\Tag;
use App\Service\HtmlParser;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class SearchController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, Environment $twig, HtmlParser $htmlParser)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->htmlParser = $htmlParser;
    }

    /**
     * @Route ("/search")
     */
    public function find(Request $request)
    {
        $query = $request->query->get('q');


        $page = $request->query->get('page', 1);
        $postRepository = $this->entityManager->getRepository(Post::class);
        $tagRepository = $this->entityManager->getRepository(Tag::class);

        $tags = $tagRepository->findAllLimit();

        $pagination = $postRepository->findByText($query, $page);
        $htmlContent = $this->twig->render(
            'search/index.html.twig',
            compact('pagination', 'query', 'tags'));

        $htmlContent = $this->htmlParser->tagsToLinks($htmlContent);
        $htmlContent = $this->htmlParser->addColor($htmlContent, $query);

        return new Response($htmlContent);
    }
}