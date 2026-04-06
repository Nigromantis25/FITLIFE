<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cliente>
 */
class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    /**
     * Busca un cliente por cédula.
     */
    public function findOneByCedula(string $cedula): ?Cliente
    {
        return $this->findOneBy(['cedula' => $cedula]);
    }

    /**
     * Obtiene todos los clientes activos.
     */
    public function findAllActive(): array
    {
        return $this->findBy(['estado' => true], ['nombre' => 'ASC']);
    }

    /**
     * Obtiene todos los clientes inactivos.
     */
    public function findAllInactive(): array
    {
        return $this->findBy(['estado' => false], ['nombre' => 'ASC']);
    }

    /**
     * Busca clientes por nombre o apellido.
     */
    public function findBySearchTerm(string $term): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.nombre LIKE :term OR c.apellido LIKE :term OR c.cedula LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('c.nombre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Cuenta clientes activos.
     */
    public function countActive(): int
    {
        return $this->count(['estado' => true]);
    }

    /**
     * Obtiene una página de clientes.
     */
    public function findPaginated(int $offset, int $limit): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.nombre', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Cuenta el total de clientes.
     */
    public function countAll(): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
