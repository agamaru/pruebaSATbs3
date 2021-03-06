<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TipoDispositivo;
use AppBundle\Form\Type\TipoDispositivoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TipoDispositivoController extends Controller
{
    /**
     * @Route("/tipos/dispositivo", name="tipo_dispositivo_listar")
     * @Security("is_granted('ROLE_USER')")
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
     * @Security("is_granted('TIPO_DISPOSITIVO_VER', tipoDispositivo)")
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
     * @Security("is_granted('TIPO_DISPOSITIVO_CREAR')")
     */
    public function nuevaAction(Request $request)
    {
        $tipoDispositivo = new TipoDispositivo();
        $this->getDoctrine()->getManager()->persist($tipoDispositivo);

        return $this->formularioAction($request, $tipoDispositivo);
    }

    /**
     * @Route("/tipos/dispositivo/editar/{id}", name="tipo_dispositivo_editar")
     * @Security("is_granted('TIPO_DISPOSITIVO_EDITAR', tipoDispositivo)")
     */
    public function editarAction(Request $request, TipoDispositivo $tipoDispositivo)
    {
        return $this->formularioAction($request, $tipoDispositivo);
    }


    public function formularioAction(Request $request, TipoDispositivo $tipoDispositivo)
    {
        $em = $this->getDoctrine()->getManager();

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
            'tipoDispositivo' => $tipoDispositivo,
            'formulario' => $form->createView()
        ]);
    }


    /**
     * @Route("/tipos/dispositivo/eliminar/{id}", name="tipo_dispositivo_eliminar")
     * @Security("is_granted('TIPO_DISPOSITIVO_ELIMINAR', tipoDispositivo)")
     */
    public function eliminarAction(Request $request, TipoDispositivo $tipoDispositivo)
    {
        $dispositivos = $this->getDoctrine()->getRepository('AppBundle:DispositivoRed')->findByTipo($tipoDispositivo);

        $resultado = count($dispositivos);

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $this->getDoctrine()->getRepository('AppBundle:TipoDispositivo')->delete($tipoDispositivo);
                $em->flush();
                $this->addFlash('info', 'El tipo de dispositivo ha sido eliminado');

            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el tipo de dispositivo');
            }
            return $this->redirectToRoute('tipo_dispositivo_listar');
        }

        return $this->render('tipo_dispositivo/eliminar.html.twig', [
            'tipoDispositivo' => $tipoDispositivo,
            'resultado' => $resultado
        ]);
    }

}
