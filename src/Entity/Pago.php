<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table(name="pago", indexes={@ORM\Index(name="IDX_F4DF5F3E2360BE51", columns={"membresia_cliente_id"}), @ORM\Index(name="IDX_F4DF5F3E5D430949", columns={"personal_id"})})
 * @ORM\Entity
 */
class Pago
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
     * @ORM\Column(name="monto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $monto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pago", type="date", nullable=false)
     */
    private $fechaPago;

    /**
     * @var string
     *
     * @ORM\Column(name="metodo_pago", type="string", length=50, nullable=false)
     */
    private $metodoPago;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var \MembresiaCliente
     *
     * @ORM\ManyToOne(targetEntity="MembresiaCliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="membresia_cliente_id", referencedColumnName="id")
     * })
     */
    private $membresiaCliente;

    /**
     * @var \Personal
     *
     * @ORM\ManyToOne(targetEntity="Personal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personal_id", referencedColumnName="id")
     * })
     */
    private $personal;


}
