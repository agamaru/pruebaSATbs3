<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Software;
use AppBundle\Form\Type\SoftwareType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/software/editar/nuevo", name="software_nuevo")
     * @Route("/software/editar/{id}", name="software_editar")
     */
    public function crearAction(Request $request, Software $software = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = false;

        if (null === $software) {
            $nuevo = true;
            $software = new software();
            $em->persist($software);
        }

        $form = $this->createForm(SoftwareType::class, $software, [
            'nuevo' => $nuevo,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('software_listar');
        }

        return $this->render('software/form.html.twig', [
            'software' => $software,
            'formulario' => $form->createView()
        ]);
    }
}
