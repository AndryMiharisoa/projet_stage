<?php

namespace App\Repository;

use App\Entity\Etudient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etudient>
 *
 * @method Etudient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etudient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etudient[]    findAll()
 * @method Etudient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudient::class);
    }

//    /**
//     * @return Etudient[] Returns an array of Etudient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Etudient
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function index($searchInput, $serieFilter)
{
    $queryBuilder = $this->createQueryBuilder('e');

    // Filtre par nom et prénom
    if ($searchInput) {
        $queryBuilder
            ->andWhere('e.nom LIKE :searchInput OR e.prenom LIKE :searchInput')
            ->setParameter('searchInput', '%' . $searchInput . '%');
    }

    // Filtre par série
    if ($serieFilter) {
        $queryBuilder
            ->andWhere('e.serie = :serieFilter')
            ->setParameter('serieFilter', $serieFilter);
    }

    return $queryBuilder->getQuery()->getResult();
}

}
