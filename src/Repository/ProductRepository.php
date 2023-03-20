<?php

namespace App\Repository;

use App\Data\Filtre;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator=$paginator;
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
     /**
     * @return PaginationInterface
     */
    public function recherche(Filtre $filtre): PaginationInterface{
       $min = $filtre->min;
       $max = $filtre->max;
        $query = $this
        ->createQueryBuilder('p')
        ->select('p as product','COUNT(l.id) as likes, COUNT(n.id) as comment')
        ->leftJoin('p.likes','l')
        ->leftJoin('p.reviews','n')
        ->groupBy('p.id');
       if(!empty($min)){
            $query = $query
            ->andWhere('p.price>=:min')
            ->setParameter('min',$min);
        }
        if(!empty($max)){
            $query = $query
            ->andWhere('p.price<=:max')
            ->setParameter('max',$max);
        }
        
        
        $query = $query->getQuery();
        return $this->paginator->paginate(
                $query,
                $filtre->page,
                6
        );

    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findProductsByRate(): array
    {
        return $this->createQueryBuilder('p')
            //->andWhere('p.exampleField = :val')
            ->leftJoin('p.reviews', 'r')
            ->addSelect('AVG(r.rate) as HIDDEN moyenne')
            ->orderBy('moyenne', 'DESC')
            ->setMaxResults(10)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }



    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
