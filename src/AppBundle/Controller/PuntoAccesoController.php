<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PuntoAccesoController extends Controller
{
    /**
     * @Route("/ptosacceso", name="ptoacceso_listar")
     */
    public function listarAction()
    {
        $ptosAcceso = $this->getDoctrine()->getRepository('AppBundle:PuntoAcceso')->findAll();

        return $this->render('puntoacceso/listar.html.twig', [
            'ptosAcceso' => $ptosAcceso
        ]);
    }
}
