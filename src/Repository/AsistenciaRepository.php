<?php

namespace App\Repository;

use App\Entity\Asistencia;
use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Asistencia>
 */
class AsistenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asistencia::class);
    }

    /**
     * Obtiene todas las asistencias con sus clientes.
     */
    public function findAllWithClientes(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.cliente', 'c')
            ->addSelect('c')
            ->orderBy('a.fecha', 'DESC')
            ->addOrderBy('a.horaEntrada', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene asistencias del día actual.
     */
    public function findByToday(): array
    {
        $today = new \DateTime('today');
        
        return $this->createQueryBuilder('a')
            ->leftJoin('a.cliente', 'c')
            ->addSelect('c')
            ->where('a.fecha = :fecha')
            ->setParameter('fecha', $today)
            ->orderBy('a.horaEntrada', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene asistencias de una semana.
     */
    public function findByLastDays(int $days = 7): array
    {
        $startDate = new \DateTime("-{$days} days");
        
        return $this->createQueryBuilder('a')
            ->leftJoin('a.cliente', 'c')
            ->addSelect('c')
            ->where('a.fecha >= :startDate')
            ->setParameter('startDate', $startDate)
            ->orderBy('a.fecha', 'DESC')
            ->addOrderBy('a.horaEntrada', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene la última asistencia de un cliente (para verificar si ya entró hoy).
     */
    public function findLastByCliente(Cliente $cliente): ?Asistencia
    {
        return $this->createQueryBuilder('a')
            ->where('a.cliente = :cliente')
            ->setParameter('cliente', $cliente)
            ->orderBy('a.fecha', 'DESC')
            ->addOrderBy('a.horaEntrada', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Obtiene asistencias de un cliente en una fecha.
     */
    public function findByClienteAndFecha(Cliente $cliente, \DateTime $fecha): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.cliente = :cliente')
            ->andWhere('a.fecha = :fecha')
            ->setParameter('cliente', $cliente)
            ->setParameter('fecha', $fecha)
            ->orderBy('a.horaEntrada', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cuenta asistencias de hoy.
     */
    public function countToday(): int
    {
        $today = new \DateTime('today');
        
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.fecha = :fecha')
            ->setParameter('fecha', $today)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Obtiene asistencias sin salida registrada (clientes activos en el gimnasio).
     */
    public function findActiveClientes(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.cliente', 'c')
            ->addSelect('c')
            ->where('a.horaSalida IS NULL')
            ->orderBy('a.horaEntrada', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
