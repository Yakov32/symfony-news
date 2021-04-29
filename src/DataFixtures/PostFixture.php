<?php


namespace App\DataFixtures;


use App\Entity\Post;
use App\Repository\TagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getOrder(){
        return 20;
    }

    public function load(ObjectManager $manager)
    {
        $post = new Post(1);
        $post->setText('Obema ypala');
        $post->setPublishedAt(new \DateTime());
        $post->getTags()->add($this->tagRepository->findOneBy(['name' => 'History']));
        $post->getTags()->add($this->tagRepository->findOneBy(['name' => 'News']));

        $post1 = new Post(2);
        $post1->setText('James Wasovsky won the test');
        $post1->setPublishedAt(new \DateTime());
        $post1->getTags()->add($this->tagRepository->findOneBy(['name' => 'Sport']));
        $post1->getTags()->add($this->tagRepository->findOneBy(['name' => 'History']));

        $manager->persist($post);
        $manager->persist($post1);
        $manager->flush();
    }
}