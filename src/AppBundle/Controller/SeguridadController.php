<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SeguridadController extends Controller
{
    /**
     * @Route("/entrar", name="usuario_entrar")
     */
    public function entrarAction(AuthenticationUtils $authenticationUtils)
    {
        // obtener el error de autenticación (si se produce alguno)
        $error = $authenticationUtils->getLastAuthenticationError();

        // obtener el nombre del último usuario
        $ultimoUsuario = $authenticationUtils->getLastUsername();

        return $this->render('seguridad/entrar.html.twig', [
            'ultimo_usuario' => $ultimoUsuario,
            'error' => $error
        ]);
    }

    /**
     * @Route("/salir", name="usuario_salir")
     */
    public function salirAction()
    {
    }
}
