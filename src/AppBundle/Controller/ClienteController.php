<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClienteController extends Controller
{
    /**
     * @Route("/clientes", name="cliente_listar")
     */
    public function listarAction()
    {
        $clientes = $this->getDoctrine()->getRepository('AppBundle:Cliente')->findAll();

        return $this->render('cliente/listar.html.twig', [
            'clientes' => $clientes
        ]);
    }
}
