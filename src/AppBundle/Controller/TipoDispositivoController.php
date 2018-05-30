<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoDispositivo;
use AppBundle\Form\Type\TipoDispositivoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TipoDispositivoController extends Controller
{
    /**
     * @Route("/tipos/dispositivo", name="tipo_dispositivo_listar")
     */
    public function listarAction()
    {
        $tipos = $this->getDoctrine()->getRepository('AppBundle:TipoDispositivo')->findAllOrderedByNombre();

            return $this->render('tipo_dispositivo/listar.html.twig', [
                'tipos' => $tipos
            ]);
    }

    /**
     * @Route("/tipo/dispositivo/{id}", name="tipo_dispositivo_mostrar")
     */
    public function mostrarAction(TipoDispositivo $tipoDispositivo)
    {
        $tipos = $this->getDoctrine()->getRepository('AppBundle:TipoDispositivo')->findAllOrderedByNombre();

        $dispositivos = $this->getDoctrine()->getRepository('AppBundle:DispositivoRed')->findByTipo($tipoDispositivo);

        return $this->render('tipo_dispositivo/mostrar.html.twig', [
            'tipoDispositivo' => $tipoDispositivo,
            'dispositivos' => $dispositivos,
            'tipos' => $tipos
        ]);
    }

    /**
     * @Route("/tipos/dispositivo/editar/nuevo", name="tipo_dispositivo_nuevo")
     * @Route("/tipos/dispositivo/editar/{id}", name="tipo_dispositivo_editar")
     */
    public function crearAction(Request $request, TipoDispositivo $tipoDispositivo = null)
    {
        $tipos = $this->getDoctrine()->getRepository('AppBundle:TipoDispositivo')->findAllOrderedByNombre();

        $em = $this->getDoctrine()->getManager();

        if (null === $tipoDispositivo) {
            $tipoDispositivo = new TipoDispositivo();
            $em->persist($tipoDispositivo);
        }

        $form = $this->createForm(TipoDispositivoType::class, $tipoDispositivo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('tipo_dispositivo_listar');
        }

        return $this->render('tipo_dispositivo/form.html.twig', [
            'tipos' => $tipos,
            'tipoDispositivo' => $tipoDispositivo,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/tipos/dispositivo/eliminar/{id}", name="tipo_dispositivo_eliminar")
     */
    public function eliminarAction(Request $request, TipoDispositivo $tipoDispositivo)
    {
        $tipos = $this->getDoctrine()->getRepository('AppBundle:TipoDispositivo')->findAllOrderedByNombre();

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($tipoDispositivo);
                $em->flush();
                $this->addFlash('info', 'El tipo de dispositivo ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el tipo de dispositivo');
            }
            return $this->redirectToRoute('tipo_dispositivo_listar');
        }

        return $this->render('tipo_dispositivo/eliminar.html.twig', [
            'tipos' => $tipos,
            'tipoDispositivo' => $tipoDispositivo
        ]);
    }

}