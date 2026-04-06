<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscripcionClase
 *
 * @ORM\Table(name="inscripcion_clase", indexes={@ORM\Index(name="IDX_8EA462129F720353", columns={"clase_id"}), @ORM\Index(name="IDX_8EA46212DE734E51", columns={"cliente_id"})})
 * @ORM\Entity
 */
class InscripcionClase
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
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var \Clase
     *
     * @ORM\ManyToOne(targetEntity="Clase")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="clase_id", referencedColumnName="id")
     * })
     */
    private $clase;

    /**
     * @var \Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;


}
