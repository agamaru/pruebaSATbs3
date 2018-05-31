<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoDispositivoRepository")
 * @ORM\Table(name="tipo_dispositivo")
 * @UniqueEntity("nombre", message="Ya existe un tipo de dispositivo con ese nombre")
 */
class TipoDispositivo
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
     *     message = "Rellene este campo"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 30,
     *     minMessage = "El nombre debe tener al menos {{ limit }} caracteres",
     *     maxMessage = "El nombre no puede tener más de {{ limit }} caracteres"
     * )
     * @Assert\Regex(
     *     pattern = "/^([a-zA-Z]){2,}/",
     *     message = "El nombre introducido no tiene el formato adecuado"
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
     * @return TipoDispositivo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

}