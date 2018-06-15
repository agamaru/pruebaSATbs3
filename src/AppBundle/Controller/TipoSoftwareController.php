<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoSoftware;
use AppBundle\Form\Type\TipoSoftwareType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TipoSoftwareController extends Controller
{
    /**
     * @Route("/tipos/software", name="tipo_software_listar")
     * @Security("is_granted('ROLE_USER')")
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
     * @Security("is_granted('TIPO_SOFTWARE_VER', tipoSoftware)")
     */
    public function mostrarAction(TipoSoftware $tipoSoftware)
    {
        $tipos = $this->getDoctrine()->getRepository('AppBundle:TipoSoftware')->findAllOrderedByNombre();

        $softwares = $this->getDoctrine()->getRepository('AppBundle:Software')->findByTipo($tipoSoftware);

        return $this->render('tipo_software/mostrar.html.twig', [
            'tipoSoftware' => $tipoSoftware,
            'softwares' => $softwares,
            'tipos' => $tipos
        ]);
    }

    /**
     * @Route("/tipos/software/editar/nuevo", name="tipo_software_nuevo")
     * @Security("is_granted('TIPO_SOFTWARE_CREAR')")
     */
    public function nuevaAction(Request $request)
    {
        $tipoSoftware = new TipoSoftware();
        $this->getDoctrine()->getManager()->persist($tipoSoftware);

        return $this->editarAction($request, $tipoSoftware);
    }

    /**
     * @Route("/tipos/software/editar/{id}", name="tipo_software_editar")
     * @Security("is_granted('TIPO_SOFTWARE_EDITAR', tipoSoftware)")
     */
    public function editarAction(Request $request, TipoSoftware $tipoSoftware)
    {
        $em = $this->getDoctrine()->getManager();

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
     * @Security("is_granted('TIPO_SOFTWARE_ELIMINAR', tipoSoftware)")
     */
    public function eliminarAction(Request $request, TipoSoftware $tipoSoftware)
    {
        $softwares = $this->getDoctrine()->getRepository('AppBundle:Software')->findByTipo($tipoSoftware);

        $resultado = count($softwares);

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $this->getDoctrine()->getRepository('AppBundle:TipoSoftware')->delete($tipoSoftware);
                //$em->remove($tipoSoftware);
                $em->flush();
                $this->addFlash('info', 'El tipo de software ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el tipo de software');
            }
            return $this->redirectToRoute('tipo_software_listar');
        }

        return $this->render('tipo_software/eliminar.html.twig', [
            'tipoSoftware' => $tipoSoftware,
            'resultado' => $resultado
        ]);
    }

}
