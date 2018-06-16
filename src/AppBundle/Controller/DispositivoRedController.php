<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DispositivoRed;
use AppBundle\Entity\Empresa;
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
        $dispositivos = $this->getDoctrine()->getRepository('AppBundle:DispositivoRed')->findAllWithEmpresaAndTipoJoin();

        return $this->render('disposivito_red/listar.html.twig', [
            'dispositivos' => $dispositivos
        ]);
    }

    /**
     * @Route("/dispositivo/nuevo", name="dispositivo_nuevo")
     * @Route("servicios/dispositivo/nuevo/{id}", name="dispositivo_servicio_nuevo")
     * @Security("is_granted('DISPOSITIVO_RED_CREAR')")
     */
    public function nuevaAction(Request $request, Empresa $empresa = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = true;
        $dispositivoRed = new DispositivoRed();
        if (null !== $empresa) {
            $nuevo = false;
            $dispositivoRed->setEmpresa($empresa);
        }

        $em->persist($dispositivoRed);

        return $this->formularioAction($request, $dispositivoRed, $nuevo);
    }

    /**
     * @Route("/dispositivo/editar/{id}", name="dispositivo_editar")
     * @Route("servicios/dispositivo/editar/{id}", name="dispositivo_servicio_editar")
     * @Security("is_granted('DISPOSITIVO_RED_EDITAR', dispositivo)")
     */
    public function editarAction(Request $request, DispositivoRed $dispositivo)
    {
        return $this->formularioAction($request, $dispositivo);
    }

    /**
     * @Route("/dispositivo/detalles/{id}", name="dispositivo_detalles")
     * @Route("servicios/dispositivo/detalles/{id}", name="dispositivo_servicio_detalles")
     * @Security("is_granted('DISPOSITIVO_RED_VER', dispositivo)")
     */
    public function detallesAction(Request $request, DispositivoRed $dispositivo)
    {
        return $this->formularioAction($request, $dispositivo, $nuevo = false, $soloLectura = true);
    }

    public function formularioAction(Request $request, DispositivoRed $dispositivoRed, $nuevo = false, $soloLectura = false)
    {
        $em = $this->getDoctrine()->getManager();

        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        $form = $this->createForm(DispositivoRedType::class, $dispositivoRed, [
            'nuevo' => $nuevo,
            'admin' => $this->isGranted('ROLE_ADMIN'),
            'permiso' => $soloLectura
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');

                if (false !== $vengoDeEmpresa){
                    return $this->redirectToRoute('empresa_servicios_mostrar', array(
                        'id' => $dispositivoRed->getEmpresa()->getId()
                    ));
                }
                else {
                    return $this->redirectToRoute('dispositivo_listar');
                }

            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('disposivito_red/form.html.twig', [
            'soloLectura' => $soloLectura,
            'vengoDeEmpresa' => $vengoDeEmpresa,
            'nuevo' => $nuevo,
            'dispositivo' => $dispositivoRed,
            'formulario' => $form->createView()
        ]);
    }


    /**
     * @Route("/dispositivo/eliminar/{id}", name="dispositivo_eliminar")
     * @Route("/servicios/dispositivo/eliminar/{id}", name="dispositivo_servicio_eliminar")
     * @Security("is_granted('DISPOSITIVO_RED_ELIMINAR', dispositivo)")
     */
    public function eliminarAction(Request $request, DispositivoRed $dispositivo)
    {
        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($dispositivo);
                $em->flush();
                $this->addFlash('info', 'El dispositivo de red ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el dispositivo de red');
            }

            if (false !== $vengoDeEmpresa){
                return $this->redirectToRoute('empresa_servicios_mostrar', array(
                    'id' => $dispositivo->getEmpresa()->getId()
                ));
            }
            else {

                return $this->redirectToRoute('dispositivo_listar');
            }
        }

        return $this->render('disposivito_red/eliminar.html.twig', [
            'dispositivo' => $dispositivo,
            'vengoDeEmpresa' => $vengoDeEmpresa
        ]);
    }
}
