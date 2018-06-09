<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     * @Security("is_granted('ROLE_USER')")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}
