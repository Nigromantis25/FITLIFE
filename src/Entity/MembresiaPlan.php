<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembresiaPlan
 *
 * @ORM\Table(name="membresia_plan")
 * @ORM\Entity
 */
class MembresiaPlan
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_plan", type="string", length=100, nullable=false)
     */
    private $nombrePlan;

    /**
     * @var string
     *
     * @ORM\Column(name="costo", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $costo;

    /**
     * @var int
     *
     * @ORM\Column(name="duracion_dias", type="integer", nullable=false)
     */
    private $duracionDias;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;


}
