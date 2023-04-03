<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Mission::class);
        $this->paginator = $paginator;
    }

    public function save(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int $limit
     * @return int
     */
    public function findLatest(int $limit = 10)
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.startDate', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Allow to research into users by filters and therms
     *
     * @param string $searchTerm
     * @param array $selectedLanguages
     * @param int $page
     * @param int $itemsPerPage
     * @return array
     */
    public function searchMissions(string $searchTerm, array $selectedLanguages, int $page = 1, int $itemsPerPage = 10): array
    {
        $queryBuilder = $this->createQueryBuilder('m');

        if(!empty($searchTerm)){
            $queryBuilder
                ->where('m.title LIKE :searchTerm OR m.description LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }


        if (!empty($selectedLanguages)) {
            $queryBuilder
                ->innerJoin('m.languages', 'l')
                ->andWhere('l IN (:selectedLanguages)')
                ->setParameter('selectedLanguages', $selectedLanguages);
        }

        // Ajoutez des conditions supplémentaires en fonction des filtres souhaités

        // Set the pagination
        $queryBuilder->setFirstResult(($page - 1) * $itemsPerPage)
            ->setMaxResults($itemsPerPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return PaginationInterface
     */
    public function findPaginatedMissions(int $page = 1, int $itemsPerPage = 10): PaginationInterface
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->orderBy('m.createdAt', 'DESC');

        return $this->paginator->paginate(
            $queryBuilder,
            $page,
            $itemsPerPage
        );
    }

//    /**
//     * @return Mission[] Returns an array of Mission objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Mission
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
