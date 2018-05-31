<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DispositivoRedRepository")
 * @ORM\Table(name="dispositivo_red")
 */
class DispositivoRed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $id;

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
    private $password;

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
    private $wep;

    /**
     * @ORM\ManyToOne(targetEntity="TipoDispositivo")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(
     *     message = "Rellene este campo"
     * )
     *
     * @var TipoDispositivo
     */
    private $tipo;

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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return DispositivoRed
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
     * @return DispositivoRed
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return DispositivoRed
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getWep()
    {
        return $this->wep;
    }

    /**
     * @param string $wep
     * @return DispositivoRed
     */
    public function setWep($wep)
    {
        $this->wep = $wep;
        return $this;
    }

    /**
     * @return TipoDispositivo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param TipoDispositivo $tipo
     * @return DispositivoRed
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
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
     * @return DispositivoRed
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

}