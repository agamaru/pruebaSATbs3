<?php
/**
 * Created by PhpStorm.
 * User: elsiore
 * Date: 20/05/18
 * Time: 18:41
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario
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
    private $nombreUsuario;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    private $admin;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean
     */
    private $tecnico;

    /**
     * @ORM\ManyToOne(targetEntity="Servidor")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Servidor
     */
    private $servidor;


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
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @param string $nombreUsuario
     * @return Usuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
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
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @param bool $admin
     * @return Usuario
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTecnico()
    {
        return $this->tecnico;
    }

    /**
     * @param bool $tecnico
     * @return Usuario
     */
    public function setTecnico($tecnico)
    {
        $this->tecnico = $tecnico;
        return $this;
    }

    /**
     * @return Servidor
     */
    public function getServidor()
    {
        return $this->servidor;
    }

    /**
     * @param Servidor $servidor
     * @return Usuario
     */
    public function setServidor($servidor)
    {
        $this->servidor = $servidor;
        return $this;
    }

}