<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RouterController extends Controller
{
    /**
     * @Route("/routers", name="router_listar")
     */
    public function listarAction()
    {
        $routers = $this->getDoctrine()->getRepository('AppBundle:Router')->findAll();

        return $this->render('router/listar.html.twig', [
            'routers' => $routers
        ]);
    }
}
