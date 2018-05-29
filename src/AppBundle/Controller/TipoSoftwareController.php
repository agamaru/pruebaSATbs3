<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoSoftware;
use AppBundle\Form\Type\TipoSoftwareType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TipoSoftwareController extends Controller
{
    /**
     * @Route("/tipos/software", name="tipo_software_listar")
     */
    public function listarAction()
    {
        $tipos = $this->getDoctrine()->getRepository('AppBundle:TipoSoftware')->findAllOrderedByNombre();

            return $this->render('tipo_software/listar.html.twig', [
                'tipos' => $tipos
            ]);
    }

    /**
     * @Route("/tipo/software/{id}", name="tipo_software_mostrar")
     */
    public function mostrarAction(TipoSoftware $tipoSoftware)
    {
        //$tipos = $this->getDoctrine()->getRepository('AppBundle:TipoSoftware')->findAllOrderedByNombre();

        $softwares = $this->getDoctrine()->getRepository('AppBundle:Software')->findByTipo($tipoSoftware);

        return $this->render('tipo_software/mostrar.html.twig', [
            'tipoSoftware' => $tipoSoftware,
            'softwares' => $softwares
        ]);
    }

    /**
     * @Route("/tipos/software/editar/nuevo", name="tipo_software_nuevo")
     * @Route("/tipos/software/editar/{id}", name="tipo_software_editar")
     */
    public function crearAction(Request $request, TipoSoftware $tipoSoftware = null)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $tipoSoftware) {
            $tipoSoftware = new TipoSoftware();
            $em->persist($tipoSoftware);
        }

        $form = $this->createForm(TipoSoftwareType::class, $tipoSoftware);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('tipo_software_listar');
        }

        return $this->render('tipo_software/form.html.twig', [
            'tipoSoftware' => $tipoSoftware,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/tipos/software/eliminar/{id}", name="tipo_software_eliminar")
     */
    public function eliminarAction(Request $request, TipoSoftware $tipoSoftware)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($tipoSoftware);
                $em->flush();
                $this->addFlash('info', 'El tipo de software ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el tipo de software');
            }
            return $this->redirectToRoute('tipo_software_listar');
        }

        return $this->render('tipo_software/eliminar.html.twig', [
            'tipoSoftware' => $tipoSoftware
        ]);
    }

}
