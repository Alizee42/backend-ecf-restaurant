<?php

namespace App\Repository;

use App\Entity\PlaceDisponible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlaceDisponible>
 *
 * @method PlaceDisponible|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaceDisponible|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaceDisponible[]    findAll()
 * @method PlaceDisponible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceDisponibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaceDisponible::class);
    }

    public function save($nombre): void
    {
        $placeDisponible = new PlaceDisponible();
        $placeDisponible->setNombre($nombre);
        $this->getEntityManager()->persist($placeDisponible);
        $this->getEntityManager()->flush();
    }

    public function update(PlaceDisponible $placeDisponible): PlaceDisponible
    {
        $this->getEntityManager()->persist($placeDisponible);
        $this->getEntityManager()->flush();

        return $placeDisponible;
    }

    public function remove(PlaceDisponible $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return PlaceDisponible[] Returns an array of PlaceDisponible objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlaceDisponible
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
