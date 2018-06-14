<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoSoftwareRepository")
 * @ORM\Table(name="tipo_software")
 * @UniqueEntity("nombre", message="Ya existe un tipo de software con ese nombre")
 */
class TipoSoftware
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
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 30,
     *     minMessage = "El nombre debe tener al menos {{ limit }} caracteres",
     *     maxMessage = "El nombre no puede tener más de {{ limit }} caracteres"
     * )
     *
     * @var string
     */
    private $nombre;

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
     * @return TipoSoftware
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

}