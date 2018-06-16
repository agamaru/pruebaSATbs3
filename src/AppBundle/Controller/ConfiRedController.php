<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ConfiRed;
use AppBundle\Entity\Empresa;
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
     * @Route("servicios/confired/nueva/{id}", name="confired_servicio_nueva")
     * @Security("is_granted('CONFIRED_CREAR')")
     */
    public function nuevaAction(Request $request, Empresa $empresa = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = true;
        $confiRed = new ConfiRed();
        if (null !== $empresa) {
            $nuevo = false;
            $confiRed->setEmpresa($empresa);
        }

        $em->persist($confiRed);

        return $this->formularioAction($request, $confiRed, $nuevo);
    }

    /**
     * @Route("/confired/editar/{id}", name="confired_editar")
     * @Route("servicios/confired/editar/{id}", name="confired_servicio_editar")
     * @Security("is_granted('CONFIRED_EDITAR', confiRed) or is_granted('CONFIRED_VER', confiRed)")
     */
    public function editarAction(Request $request, ConfiRed $confiRed)
    {
        return $this->formularioAction($request, $confiRed, $nuevo = false, $soloLectura = false);
    }

    /**
     * @Route("/confired/detalles/{id}", name="confired_detalles")
     * @Route("servicios/confired/detalles/{id}", name="confired_servicio_detalles")
     * @Security("is_granted('CONFIRED_VER', confiRed)")
     */
    public function detallesAction(Request $request, ConfiRed $confiRed)
    {
        return $this->formularioAction($request, $confiRed);
    }

    public function formularioAction(Request $request, ConfiRed $confiRed, $nuevo = false, $soloLectura = true)
    {
        $em = $this->getDoctrine()->getManager();

        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
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

                if (false !== $vengoDeEmpresa){
                    return $this->redirectToRoute('empresa_servicios_mostrar', array(
                        'id' => $confiRed->getEmpresa()->getId()
                    ));
                }
                else {
                    return $this->redirectToRoute('confired_listar');
                }

            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('confired/form.html.twig', [
            'soloLectura' => $soloLectura,
            'vengoDeEmpresa' => $vengoDeEmpresa,
            'nuevo' => $nuevo,
            'confiRed' => $confiRed,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/confired/eliminar/{id}", name="confired_eliminar")
     * @Route("servicios/confired/eliminar/{id}", name="confired_servicio_eliminar")
     * @Security("is_granted('CONFIRED_ELIMINAR', confiRed)")
     */
    public function eliminarAction(Request $request, ConfiRed $confiRed)
    {
        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($confiRed);
                $em->flush();
                $this->addFlash('info', 'Configuración de red eliminada');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar la configuración de red');
            }

            if (false !== $vengoDeEmpresa){
                return $this->redirectToRoute('empresa_servicios_mostrar', array(
                    'id' => $confiRed->getEmpresa()->getId()
                ));
            }
            else {

                return $this->redirectToRoute('confired_listar');
            }

        }

        return $this->render('confired/eliminar.html.twig', [
            'confiRed' => $confiRed,
            'vengoDeEmpresa' => $vengoDeEmpresa
        ]);
    }

}
