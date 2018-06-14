<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 * @ORM\Table(name="empresa")
 * @UniqueEntity("nombre", message="Ya existe una empresa con ese nombre")
 * @UniqueEntity("cif", message="Ya existe una empresa con ese cif")
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
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Length(
     *     min = 3,
     *     minMessage = "El nombre debe tener al menos {{ limit }} caracteres",
     * )
     *
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Regex(
     *     pattern = "/^([A-Za-z]{1})(\d{7})([0-9A-Za-z]{1})$/",
     *     message = "El cif introducido no tiene el formato adecuado"
     * )
     * @Assert\Length(
     *     max=9,
     *     maxMessage = "El cif no puede tener más de {{ limit }} caracteres"
     * )
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