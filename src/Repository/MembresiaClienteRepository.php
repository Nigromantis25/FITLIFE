<?php

namespace App\Repository;

use App\Entity\MembresiaCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MembresiaCliente>
 */
class MembresiaClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembresiaCliente::class);
    }

    /**
     * Obtiene membresías que vencen en los próximos días.
     */
    public function findVencingSoon(int $days = 3): array
    {
        $today = new \DateTime();
        $futureDate = new \DateTime("+{$days} days");
        
        return $this->createQueryBuilder('m')
            ->leftJoin('m.cliente', 'c')
            ->addSelect('c')
            ->where('m.fechaVencimiento BETWEEN :today AND :futureDate')
            ->setParameter('today', $today)
            ->setParameter('futureDate', $futureDate)
            ->orderBy('m.fechaVencimiento', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cuenta membresías activas.
     */
    public function countActive(): int
    {
        return $this->count(['estado' => true]);
    }
}
