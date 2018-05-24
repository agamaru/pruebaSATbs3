<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SoftwareController extends Controller
{
    /**
     * @Route("/softwares", name="software_listar")
     */
    public function listarAction()
    {
        $softwares = $this->getDoctrine()->getRepository('AppBundle:Software')->findAll();

        return $this->render('software/listar.html.twig', [
            'softwares' => $softwares
        ]);
    }
}
