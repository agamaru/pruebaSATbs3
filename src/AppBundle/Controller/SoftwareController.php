<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Entity\Software;
use AppBundle\Form\Type\SoftwareType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SoftwareController extends Controller
{
    /**
     * @Route("/softwares", name="software_listar")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listarAction()
    {
        $softwares = $this->getDoctrine()->getRepository('AppBundle:Software')->findAllWithEmpresaAndTipoJoin();

        return $this->render('software/listar.html.twig', [
            'softwares' => $softwares
        ]);
    }

    /**
     * @Route("/software/nuevo", name="software_nuevo")
     * @Route("servicios/software/nuevo/{id}", name="software_servicio_nuevo")
     * @Security("is_granted('SOFTWARE_CREAR')")
     */
    public function nuevaAction(Request $request, Empresa $empresa = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = true;
        $software = new Software();
        if (null !== $empresa) {
            $nuevo = false;
            $software->setEmpresa($empresa);
        }

        $em->persist($software);

        return $this->formularioAction($request, $software, $nuevo, false);
    }

    /**
     * @Route("/software/editar/{id}", name="software_editar")
     * @Route("servicios/software/editar/{id}", name="software_servicio_editar")
     * @Security("is_granted('SOFTWARE_EDITAR', software)")
     */
    public function editarAction(Request $request, Software $software)
    {
        return $this->formularioAction($request, $software, false, false);
    }

    /**
     * @Route("/software/detalles/{id}", name="software_detalles")
     * @Route("servicios/software/detalles/{id}", name="software_servicio_detalles")
     * @Security("is_granted('SOFTWARE_VER', software)")
     */
    public function detallesAction(Request $request, Software $software)
    {
        return $this->formularioAction($request, $software);
    }

    public function formularioAction(Request $request, Software $software, $nuevo = false, $soloLectura = true)
    {
        $em = $this->getDoctrine()->getManager();

        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        $form = $this->createForm(SoftwareType::class, $software, [
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
                        'id' => $software->getEmpresa()->getId()
                    ));
                }
                else {
                    return $this->redirectToRoute('software_listar');
                }

            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('software/form.html.twig', [
            'soloLectura' => $soloLectura,
            'vengoDeEmpresa' => $vengoDeEmpresa,
            'nuevo' => $nuevo,
            'software' => $software,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/software/eliminar/{id}", name="software_eliminar")
     * @Route("/servicios/software/eliminar/{id}", name="software_servicio_eliminar")
     * @Security("is_granted('SOFTWARE_ELIMINAR', software)")
     */
    public function eliminarAction(Request $request, Software $software)
    {
        $vengoDeEmpresa = false;

        $ruta = $request->get('_route');

        if (false !== strpos($ruta, 'servicio')) {
            $vengoDeEmpresa = true;
        }

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($software);
                $em->flush();
                $this->addFlash('info', 'El software ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el software');
            }

            if (false !== $vengoDeEmpresa){
                return $this->redirectToRoute('empresa_servicios_mostrar', array(
                    'id' => $software->getEmpresa()->getId()
                ));
            }
            else {
                return $this->redirectToRoute('software_listar');
            }
        }

        return $this->render('software/eliminar.html.twig', [
            'software' => $software,
            'vengoDeEmpresa' => $vengoDeEmpresa
        ]);
    }
}
