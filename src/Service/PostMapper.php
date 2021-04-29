<?php


namespace App\Service;
use App\DTO\PostDTO;
use App\Entity\Post;
use App\Entity\Tag;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;

class PostMapper
{
    private $entityManager;
    private $postRepository;
    private $tagRepository;

    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository, TagRepository $tagRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    public function mapData(array $posts)
    {
        foreach($posts as $postDTO){
            if(false !== $this->verifyExist($postDTO)){
                continue;
            }
            $postEntity = $this->mapSinglePost($postDTO);
            $this->entityManager->persist($postEntity);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        return true;
    }

    public function mapSinglePost(PostDTO $postDTO): ?Post
    {
        $postEntity = new Post($postDTO->id);
        $postEntity->setText($postDTO->text);
        $postEntity->setPublishedAt(new \DateTime($postDTO->published_at));

        if ($postDTO->tags === Null) {
            return $postEntity;
        }
        foreach ($postDTO->tags as $tag) {
            $existedTag = $this->tagRepository->find($tag);

            if (null !== $existedTag) {
                $postEntity->getTags()->add($existedTag);
                continue;
            }

            $tagEntity = new Tag();
            $tagEntity->setName($tag);

            $postEntity->getTags()->add($tagEntity);
            $this->entityManager->persist($tagEntity);
        }

        return $postEntity;

    }

    public function verifyExist($postDTO): bool{
        $res = $this->postRepository->find($postDTO->id);

        if (null == $res) {
            return false;
        }
        return true;
    }
}