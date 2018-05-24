<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 20/05/18
 * Time: 14:15
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
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
     * @Assert\Length(
     *     min = 3,
     *     minMessage = "El nombre debe tener al menos {{ limit }} caracteres"
     * )
     * @Assert\NotNull()
     *
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\Regex(
     *     pattern = "/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/",
     *     message = "El cif introducido no tiene el formato adecuado"
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
        $this->cif = $cif;
        return $this;
    }

}