<?php

namespace AppBundle\Security;


use AppBundle\Entity\TipoDispositivo;
use AppBundle\Entity\Usuario;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TipoDispositivoVoter extends Voter
{
    const VER = 'TIPO_DISPOSITIVO_VER';
    const CREAR = 'TIPO_DISPOSITIVO_CREAR';
    const EDITAR = 'TIPO_DISPOSITIVO_EDITAR';
    const ELIMINAR = 'TIPO_DISPOSITIVO_ELIMINAR';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $dm)
    {
        $this->decisionManager = $dm;
    }


    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof TipoDispositivo) {
            return  $attribute === self::CREAR;
        }

        // si el atributo no está entre los que hemos definido, devolver false
        if (!in_array($attribute, [self::VER, self::CREAR, self::EDITAR, self::ELIMINAR])) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $usuario = $token->getUser();

        if (!$usuario instanceof Usuario) {
            // debería haber un usuario activo en la aplicación, denegar si no es así
            return false;
        }

        // El administrador siempre tiene permiso
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        switch ($attribute) {
            case self::VER:
                return $this->puedeVer($subject, $token, $usuario);
            case self::CREAR:
                return $this->puedeCrear($token, $usuario);
            case self::EDITAR:
                return $this->puedeEditar($subject, $token, $usuario);
            case self::ELIMINAR:
                return $this->puedeEliminar($subject, $token, $usuario);
        }

        // por defecto, denegar el permiso
        return false;
    }

    private function puedeVer(TipoDispositivo $tipoDispositivo, TokenInterface $token, Usuario $usuario)
    {
        // todos pueden ver
        return true;
    }

    private function puedeCrear(TokenInterface $token, Usuario $usuario)
    {
        // sólo el administrador puede crear
        return $this->decisionManager->decide($token, ['ROLE_ADMIN']);
    }

    private function puedeEditar(TipoDispositivo $tipoDispositivo, TokenInterface $token, Usuario $usuario)
    {
        // sólo el administrador puede modificar
        return $this->decisionManager->decide($token, ['ROLE_ADMIN']);
    }

    private function puedeEliminar(TipoDispositivo $tipoDispositivo, TokenInterface $token, Usuario $usuario)
    {
        // sólo el administrador puede eliminar
        return $this->decisionManager->decide($token, ['ROLE_ADMIN']);
    }
}