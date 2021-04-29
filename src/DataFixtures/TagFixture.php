<?php


namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends Fixture implements OrderedFixtureInterface
{
    public function getOrder(){
        return 10;
    }

    public function load(ObjectManager $manager)
    {
        $tag = new Tag();
        $tag->setName('Sport');

        $tag1 = new Tag();
        $tag1->setName('News');

        $tag2 = new Tag();
        $tag2->setName('History');

        $manager->persist($tag);
        $manager->persist($tag1);
        $manager->persist($tag2);

        $manager->flush();
    }
}