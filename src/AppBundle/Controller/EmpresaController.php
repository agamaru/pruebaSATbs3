<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Form\Type\EmpresaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmpresaController extends Controller
{
    /**
     * @Route("/empresas", name="empresa_listar")
     * @Security("is_granted('ROLE_USER')")
     */
    public function listarAction()
    {
        $empresas = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findAllOrderedByNombre();

        return $this->render('empresa/listar.html.twig', [
            'empresas' => $empresas
        ]);
    }

    /**
     * @Route("/empresa/servicios/{id}", name="empresa_servicios_mostrar")
     * @Security("is_granted('EMPRESA_VER', empresa)")
     */
    public function mostrarServiciosAction(Empresa $empresa)
    {
        $softwares = $this->getDoctrine()->getRepository('AppBundle:Software')->findByEmpresa($empresa);

        $confiRedes = $this->getDoctrine()->getRepository('AppBundle:ConfiRed')->findByEmpresa($empresa);

        $dispositivos = $this->getDoctrine()->getRepository('AppBundle:DispositivoRed')->findByEmpresa($empresa);

        $servidores = $this->getDoctrine()->getRepository('AppBundle:Servidor')->findByEmpresa($empresa);

        return $this->render('empresa/mostrar.html.twig', [
            'empresa' => $empresa,
            'softwares' => $softwares,
            'confiRedes' => $confiRedes,
            'dispositivos' => $dispositivos,
            'servidores' => $servidores
        ]);
    }

    /**
     * @Route("/empresa/nueva", name="empresa_nueva")
     * @Security("is_granted('EMPRESA_CREAR')")
     */
    public function nuevaAction(Request $request)
    {
        $empresa = new Empresa();
        $this->getDoctrine()->getManager()->persist($empresa);

        return $this->formularioAction($request, $empresa);
    }

    /**
     * @Route("/empresa/editar/{id}", name="empresa_editar")
     * @Security("is_granted('EMPRESA_EDITAR', empresa)")
     */
    public function editarAction(Request $request, Empresa $empresa)
    {
        return $this->formularioAction($request, $empresa);
    }


    public function formularioAction(Request $request, Empresa $empresa)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('empresa_listar');
        }

        return $this->render('empresa/form.html.twig', [
            'empresa' => $empresa,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/empresa/eliminar/{id}", name="empresa_eliminar")
     * @Security("is_granted('EMPRESA_ELIMINAR', empresa)")
     */
    public function eliminarAction(Request $request, Empresa $empresa)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $this->getDoctrine()->getRepository('AppBundle:Empresa')->delete($empresa);
                $em->flush();

                $this->addFlash('info', 'Empresa eliminada');

            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar la empresa');
            }
            return $this->redirectToRoute('empresa_listar');
        }

        return $this->render('empresa/eliminar.html.twig', [
            'empresa' => $empresa
        ]);
    }

}
