<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DispositivoRedController extends Controller
{
    /**
     * @Route("/dispositivos", name="dispositivo_listar")
     */
    public function listarAction()
    {
        $dispositivos = $this->getDoctrine()->getRepository('AppBundle:DispositivoRed')->findAll();

        return $this->render('disposivito_red/listar.html.twig', [
            'dispositivos' => $dispositivos
        ]);
    }
}
