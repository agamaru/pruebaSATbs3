<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServidorRepository")
 * @ORM\Table(name="servidor")
 */
class Servidor
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
     *     minMessage = "El campo debe tener al menos {{ limit }} caracteres",
     *     maxMessage = "El campo no puede tener más de {{ limit }} caracteres"
     * )
     *
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Ip(
     *     version="all",
     *     message="La ip introducida no es válida"
     * )
     *
     * @var string
     */
    private $ip;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 30,
     *     minMessage = "El campo debe tener al menos {{ limit }} caracteres",
     *     maxMessage = "El campo no puede tener más de {{ limit }} caracteres"
     * )
     *
     * @var string
     */
    private $usuario;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Length(
     *     min = 6,
     *     max = 30,
     *     minMessage = "El campo debe tener al menos {{ limit }} caracteres",
     *     maxMessage = "El campo no puede tener más de {{ limit }} caracteres"
     * )
     *
     * @var string
     */
    private $pass;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *     message = "Rellene este campo"
     * )
     * @Assert\Length(
     *     min = 3,
     *     minMessage = "El campo debe tener al menos {{ limit }} caracteres"
     * )
     *
     * @var string
     */
    private $detalles;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(
     *     message = "Rellene este campo"
     * )
     *
     * @var Empresa
     */
    private $empresa;

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
     * @return Servidor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return Servidor
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     * @return Servidor
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     * @return Servidor
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetalles()
    {
        return $this->detalles;
    }

    /**
     * @param string $detalles
     * @return Servidor
     */
    public function setDetalles($detalles)
    {
        $this->detalles = $detalles;
        return $this;
    }

    /**
     * @return Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param Empresa $empresa
     * @return Servidor
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

}