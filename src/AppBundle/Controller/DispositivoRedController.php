<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DispositivoRed;
use AppBundle\Form\Type\DispositivoRedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DispositivoRedController extends Controller
{
    /**
     * @Route("/dispositivos", name="dispositivo_listar")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listarAction()
    {
        $dispositivos = $this->getDoctrine()->getRepository('AppBundle:DispositivoRed')->findAll();

        return $this->render('disposivito_red/listar.html.twig', [
            'dispositivos' => $dispositivos
        ]);
    }

    /**
     * @Route("/dispositivo/editar/nuevo", name="dispositivo_nuevo")
     * @Route("/dispositivo/editar/{id}", name="dispositivo_editar")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function crearAction(Request $request, DispositivoRed $dispositivo = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = false;

        if (null === $dispositivo) {
            $nuevo = true;
            $dispositivo = new DispositivoRed();
            $em->persist($dispositivo);
        }

        $form = $this->createForm(DispositivoRedType::class, $dispositivo, [
            'nuevo' => $nuevo,
            'admin' => $this->isGranted('ROLE_ADMIN')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('dispositivo_listar');
        }

        return $this->render('disposivito_red/form.html.twig', [
            'dispositivo' => $dispositivo,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/dispositivo/eliminar/{id}", name="dispositivo_eliminar")
     * @Security("is_granted('DISPOSITIVO_RED_ELIMINAR', dispositivo)")
     */
    public function eliminarAction(Request $request, DispositivoRed $dispositivo)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($dispositivo);
                $em->flush();
                $this->addFlash('info', 'El dispositivo de red ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el dispositivo de red');
            }
            return $this->redirectToRoute('dispositivo_listar');
        }

        return $this->render('disposivito_red/eliminar.html.twig', [
            'dispositivo' => $dispositivo
        ]);
    }
}
