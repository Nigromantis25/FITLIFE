<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MembresiaCliente
 *
 * @ORM\Table(name="membresia_cliente", indexes={@ORM\Index(name="IDX_B62AD012DE734E51", columns={"cliente_id"}), @ORM\Index(name="IDX_B62AD012E899029B", columns={"plan_id"})})
 * @ORM\Entity
 */
class MembresiaCliente
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_vencimiento", type="date", nullable=false)
     */
    private $fechaVencimiento;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var \Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;

    /**
     * @var \MembresiaPlan
     *
     * @ORM\ManyToOne(targetEntity="MembresiaPlan")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_id", referencedColumnName="id")
     * })
     */
    private $plan;


}
