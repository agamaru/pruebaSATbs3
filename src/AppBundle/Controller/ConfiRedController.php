<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConfiRed;
use AppBundle\Entity\Empresa;
use AppBundle\Form\Type\ConfiRedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfiRedController extends Controller
{
    /**
     * @Route("/confiredes", name="confired_listar")
     */
    public function listarAction()
    {
        $confiRedes = $this->getDoctrine()->getRepository('AppBundle:ConfiRed')->findAll();

        return $this->render('confired/listar.html.twig', [
            'confiRedes' => $confiRedes
        ]);
    }

    /**
     * @Route("/confired/nueva/{id}", name="confired_crear")
     */
    public function crearAction(Request $request, Empresa $empresa)
    {
        $em = $this->getDoctrine()->getManager();

        $confired = new ConfiRed();
        $em->persist($confired);

        $form = $this->createForm(ConfiRedType::class, $confired, $empresa);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios realizados');
                return $this->redirectToRoute('empresa_servicios_mostrar', $empresa);
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
    }
}
