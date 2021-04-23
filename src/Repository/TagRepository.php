<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findAllLimit(int $limit = 17)
    {
        return $this->createQueryBuilder('t')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }

    public function findMostPopular()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        select count(1) as c, name_id as tag from 
        (SELECT pt.post_id, pt.name_id FROM posts_tags pt join post p on pt.post_id = p.id and p.published_at >= '2021-02-01 00:00:00') sub
        GROUP BY tag
        ORDER BY c DESC
        LIMIT 17";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }
}
