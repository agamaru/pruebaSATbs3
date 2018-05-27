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
     * @Route("/confired/nueva/{id}", name="confired_nueva")
     * @Route("/confired/nueva", name="confired_crear")
     */
    public function crearAction(Request $request, Empresa $empresa = null)
    {
        $em = $this->getDoctrine()->getManager();

        $tengoEmpresa = false;

        $confired = new ConfiRed();

        if (null !== $empresa) { // si tengo la empresa, se la asigno
            $tengoEmpresa = true;
            $confired->setEmpresa($empresa);
        }

        $em->persist($confired);

        $form = $this->createForm(ConfiRedType::class, $confired, [
            'tengoEmpresa' => $tengoEmpresa
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            if (true === $tengoEmpresa){
                return $this->redirectToRoute('empresa_servicios_mostrar', [
                    'id' => $empresa->getId()
                ]);
            } else {
                return $this->redirectToRoute('confired_listar');
                // redirige a esta y con errores, pero en realidad se guardan
            }
        }

        return $this->render('confired/form.html.twig', [
            'confired' => $confired,
            'empresa' => $empresa,
            'formulario' => $form->createView()
        ]);
    }
}
