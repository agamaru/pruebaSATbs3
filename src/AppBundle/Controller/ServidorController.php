<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServidorController extends Controller
{
    /**
     * @Route("/servidores", name="servidor_listar")
     */
    public function listarAction()
    {
        $servidores = $this->getDoctrine()->getRepository('AppBundle:Servidor')->findAll();

        return $this->render('servidor/listar.html.twig', [
            'servidores' => $servidores
        ]);
    }
}
