<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 19/05/18
 * Time: 18:46
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SoftwareRepository")
 * @ORM\Table(name="software")
 */
class Software
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
     *
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $usuario;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="date")
     *
     * @var \DateTime
     */
    private $fechaRenovacion;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $notas;

    /**
     * @ORM\ManyToOne(targetEntity="TipoSoftware")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var TipoSoftware
     */
    private $tipo;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumn(nullable=false)
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return Software
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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
     * @return Software
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
     * @return Software
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaRenovacion()
    {
        return $this->fechaRenovacion;
    }

    /**
     * @param \DateTime $fechaRenovacion
     * @return Software
     */
    public function setFechaRenovacion($fechaRenovacion)
    {
        $this->fechaRenovacion = $fechaRenovacion;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * @param string $notas
     * @return Software
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;
        return $this;
    }

    /**
     * @return TipoSoftware
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param TipoSoftware $tipo
     * @return Software
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
     * @return Software
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

}