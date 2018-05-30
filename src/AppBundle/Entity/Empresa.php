<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as MyAssert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 * @ORM\Table(name="empresa")
 */
class Empresa
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message = "El campo es obligatorio"
     * )
     * @Assert\Length(
     *     min = 3,
     *     minMessage = "El nombre debe tener al menos {{ limit }} caracteres"
     * )
     *
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message = "El campo es obligatorio"
     * )
     *
     * @MyAssert\Cif
     *
     * @var string
     */
    private $cif;

    public function __toString()
    {
        return $this->getNombre();
    }

    /// Getters y setters

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Empresa
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * @param string $cif
     * @return Empresa
     */
    public function setCif($cif)
    {
        $this->cif = strtoupper($cif);
        return $this;
    }

}