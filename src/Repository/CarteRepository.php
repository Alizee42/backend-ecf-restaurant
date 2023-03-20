<?php

namespace App\Repository;

use App\Entity\Carte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carte>
 *
 * @method Carte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carte[]    findAll()
 * @method Carte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carte::class);
    }

    public function save($titre, $description, $prix, $estPublie): void
    {
        $carte = new Carte();
        $carte->setTitre($titre);
        $carte->setDescription($description);
        $carte->setPrix($prix);
        $carte->setEstPublie($estPublie);
        $carte->setImage("assets/images/");
        $this->getEntityManager()->persist($carte);
        $this->getEntityManager()->flush();
    }

    public function update(Carte $carte): Carte
    {
        $this->getEntityManager()->persist($carte);
        $this->getEntityManager()->flush();

        return $carte;
    }

    public function remove(Carte $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return Carte[] Returns an array of Carte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Carte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
