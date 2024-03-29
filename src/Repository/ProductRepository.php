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
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
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
   public function search($cat, $q, Filtre $filtre): PaginationInterface
   {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.active = TRUE')
            ->select('p as product', 'COUNT(l.id) as likes, AVG(r.rate) as reviews')
            ->leftJoin('p.likes', 'l')
            ->leftJoin('p.reviews', 'r')
            ->groupBy('p.id');
        ;
        if($cat != null) {
            $query = $query
                ->andWhere('p.category = :cat')
                ->setParameter('cat', $cat)
            ;
        }
        if($q != '') {
            $query = $query
                ->andWhere('p.name LIKE :q')
                ->setParameter('q', '%'.$q.'%')
            ;
        }
        if($filtre != null) {
            $min = $filtre->min;
            $max = $filtre->max;
            if(!empty($min)){
                $query = $query
                    ->andWhere('p.price >= :min')
                    ->setParameter('min', $min);
            }
            if(!empty($max)){
                $query = $query
                    ->andWhere('p.price <= :max')
                    ->setParameter('max', $max);
            }
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
