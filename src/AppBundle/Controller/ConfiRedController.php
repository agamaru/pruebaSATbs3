<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConfiRed;
use AppBundle\Form\Type\ConfiRedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfiRedController extends Controller
{
    /**
     * @Route("/confiredes", name="confired_listar")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listarAction()
    {
        $confiRedes = $this->getDoctrine()->getRepository('AppBundle:ConfiRed')->findAllWithEmpresaJoin();

        return $this->render('confired/listar.html.twig', [
            'confiRedes' => $confiRedes
        ]);
    }

    /**
     * @Route("/confired/nueva", name="confired_nueva")
     * @Security("is_granted('CONFIRED_CREAR')")
     */
    public function nuevaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nuevo = true;
        $confiRed = new ConfiRed();
        $em->persist($confiRed);

        return $this->formularioAction($request, $confiRed, $nuevo);
    }

    /**
     * @Route("/confired/editar/{id}", name="confired_editar")
     * @Route("/confired/detalles/{id}", name="confired_detalles")
     * @Security("is_granted('CONFIRED_EDITAR', confiRed) or is_granted('CONFIRED_VER', confiRed)")
     */
    public function editarAction(Request $request, ConfiRed $confiRed)
    {
        // ¿separa para mayor protección de la ruta?
        return $this->formularioAction($request, $confiRed);
    }


    public function formularioAction(Request $request, ConfiRed $confiRed, $nuevo = false)
    {
        $em = $this->getDoctrine()->getManager();

        $soloLectura = true;

        if (!strpos($request->get('_route'), 'detalles') and $this->isGranted('CONFIRED_EDITAR', $confiRed)) {
            $soloLectura = false;
        }

        $form = $this->createForm(ConfiRedType::class, $confiRed, [
            'nuevo' => $nuevo,
            'admin' => $this->isGranted('ROLE_ADMIN'),
            'permiso' => $soloLectura
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');

                return $this->redirectToRoute('confired_listar');

            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('confired/form.html.twig', [
            'soloLectura' => $soloLectura,
            'confiRed' => $confiRed,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/confired/eliminar/{id}", name="confired_eliminar")
     * @Security("is_granted('CONFIRED_ELIMINAR', confiRed)")
     */
    public function eliminarAction(Request $request, ConfiRed $confiRed)
    {

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($confiRed);
                $em->flush();
                $this->addFlash('info', 'Configuración de red eliminada');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar la configuración de red');
            }

            return $this->redirectToRoute('confired_listar');

        }

        return $this->render('confired/eliminar.html.twig', [
            'confiRed' => $confiRed
        ]);
    }

}
