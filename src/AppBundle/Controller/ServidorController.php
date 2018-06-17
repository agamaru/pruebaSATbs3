<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Servidor;
use AppBundle\Form\Type\ServidorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServidorController extends Controller
{
    /**
     * @Route("/servidores", name="servidor_listar")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listarAction()
    {
        $servidores = $this->getDoctrine()->getRepository('AppBundle:Servidor')->findAllWithEmpresaJoin();

        return $this->render('servidor/listar.html.twig', [
            'servidores' => $servidores
        ]);
    }

    /**
     * @Route("/servidor/nuevo", name="servidor_nuevo")
     * @Route("servicios/servidor/nuevo/{id}", name="servidor_servicio_nuevo")
     * @Security("is_granted('SERVIDOR_CREAR')")
     */
    public function nuevaAction(Request $request, Empresa $empresa = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = true;
        $servidor = new Servidor();
        if (null !== $empresa) {
            $nuevo = false;
            $servidor->setEmpresa($empresa);
        }

        $em->persist($servidor);

        return $this->formularioAction($request, $servidor, $nuevo, false);
    }

    /**
     * @Route("/servidor/editar/{id}", name="servidor_editar")
     * @Route("servicios/servidor/editar/{id}", name="servidor_servicio_editar")
     * @Security("is_granted('SERVIDOR_EDITAR', servidor)")
     */
    public function editarAction(Request $request, Servidor $servidor)
    {
        return $this->formularioAction($request, $servidor, false, false);
    }

    /**
     * @Route("/servidor/detalles/{id}", name="servidor_detalles")
     * @Route("servicios/servidor/detalles/{id}", name="servidor_servicio_detalles")
     * @Security("is_granted('SERVIDOR_VER', servidor)")
     */
    public function detallesAction(Request $request, Servidor $servidor)
    {
        return $this->formularioAction($request, $servidor);
    }

    public function formularioAction(Request $request, Servidor $servidor, $nuevo = false, $soloLectura = true)
    {
        $em = $this->getDoctrine()->getManager();

        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        $form = $this->createForm(ServidorType::class, $servidor, [
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
                        'id' => $servidor->getEmpresa()->getId()
                    ));
                }
                else {
                    return $this->redirectToRoute('servidor_listar');
                }

            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('servidor/form.html.twig', [
            'soloLectura' => $soloLectura,
            'vengoDeEmpresa' => $vengoDeEmpresa,
            'nuevo' => $nuevo,
            'servidor' => $servidor,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/servidor/eliminar/{id}", name="servidor_eliminar")
     * @Route("servicios/servidor/eliminar/{id}", name="servidor_servicio_eliminar")
     * @Security("is_granted('SERVIDOR_ELIMINAR', servidor)")
     */
    public function eliminarAction(Request $request, Servidor $servidor)
    {
        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($servidor);
                $em->flush();
                $this->addFlash('info', 'El servidor ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el servidor');
            }
            if (false !== $vengoDeEmpresa){
                return $this->redirectToRoute('empresa_servicios_mostrar', array(
                    'id' => $servidor->getEmpresa()->getId()
                ));
            }
            else {
                return $this->redirectToRoute('servidor_listar');
            }
        }

        return $this->render('servidor/eliminar.html.twig', [
            'servidor' => $servidor,
            'vengoDeEmpresa' => $vengoDeEmpresa
        ]);
    }
}
