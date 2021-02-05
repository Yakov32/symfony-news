<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Post::class);
        
        $this->paginator = $paginator;
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */

    public function findAllOrderedBy(int $page = 1)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery();

        $pagination = $this->paginator->paginate($query,$page, 5);

        return $pagination;
    }

    public function findByTag($tag)
    {
        return $this->createQueryBuilder('p')
            ->join('p.tags', 't')
            ->where("t.name = :tag")
            ->setParameter('tag', $tag)
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findByText($text, $page = 1, $limit = 5)
    {
        //LIKE used because don't have time on some better:(
        $query = $this->createQueryBuilder('p')
            ->where('p.text LIKE :text')
            ->setParameter('text', '%'. $text. '%')
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery();

        $pagination = $this->paginator->paginate($query, $page, $limit);

        return $pagination;
    }
}
