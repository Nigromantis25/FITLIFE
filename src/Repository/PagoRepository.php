<?php

namespace App\Repository;

use App\Entity\Pago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pago>
 */
class PagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pago::class);
    }

    /**
     * Obtiene pagos del día actual.
     */
    public function findByToday(): array
    {
        $today = new \DateTime('today');
        
        return $this->createQueryBuilder('p')
            ->where('p.fecha = :fecha')
            ->setParameter('fecha', $today)
            ->orderBy('p.fecha', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Suma del dinero pagado en los últimos días.
     */
    public function sumByLastDays(int $days = 7): float
    {
        $startDate = new \DateTime("-{$days} days");
        
        $result = $this->createQueryBuilder('p')
            ->select('SUM(p.monto)')
            ->where('p.fecha >= :startDate')
            ->setParameter('startDate', $startDate)
            ->getQuery()
            ->getSingleScalarResult();
            
        return $result ?? 0.0;
    }
}
