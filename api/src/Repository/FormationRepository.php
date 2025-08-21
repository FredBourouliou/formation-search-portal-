<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    public function findPaginated(
        int $page = 1,
        int $limit = 10,
        ?string $search = null,
        ?string $departement = null,
        ?string $modalite = null
    ): array {
        $qb = $this->createQueryBuilder('f');

        if ($search) {
            $qb->andWhere('f.titre LIKE :search OR f.organisme LIKE :search OR f.ville LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        if ($departement) {
            $qb->andWhere('f.departement = :departement')
               ->setParameter('departement', $departement);
        }

        if ($modalite) {
            $qb->andWhere('f.modalite = :modalite')
               ->setParameter('modalite', $modalite);
        }

        $qb->orderBy('f.titre', 'ASC');

        $paginator = new Paginator($qb);
        $paginator->getQuery()
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $total = count($paginator);
        $items = [];
        
        foreach ($paginator as $formation) {
            $items[] = $formation;
        }

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'pages' => (int) ceil($total / $limit)
        ];
    }

    public function save(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}