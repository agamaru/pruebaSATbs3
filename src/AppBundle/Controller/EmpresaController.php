<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Empresa;
use AppBundle\Form\Type\EmpresaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmpresaController extends Controller
{
    /**
     * @Route("/empresas", name="empresa_listar")
     */
    public function listarAction()
    {
        $empresas = $this->getDoctrine()->getRepository('AppBundle:Empresa')->findAll();

        return $this->render('empresa/listar.html.twig', [
            'empresas' => $empresas
        ]);
    }

    /**
     * @Route("/empresa/servicios/{id}", name="empresa_servicios_mostrar")
     */
    public function mostrarAction(Empresa $empresa)
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
     * @Route("/empresa/prueba/{id}", name="empresa_probar")
     */
    public function probarAction(Request $request, Empresa $empresa)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios realizados');
                return $this->redirectToRoute('empresa_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('empresa/form.html.twig', [
            'empresa' => $empresa,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/empresa/nueva", name="empresa_nueva")
     */
    public function nuevaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $empresa = new Empresa();
        $em->persist($empresa);

        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios realizados');
                return $this->redirectToRoute('empresa_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('empresa/form.html.twig', [
            'empresa' => $empresa,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/empresa/eliminar/{id}", name="empresa_eliminar")
     */
    public function eliminarAction(Request $request, Empresa $empresa)
    {
        if ($request->isMethod('POST')) {
            try {
                $this->getDoctrine()->getRepository('AppBundle:Empresa')->delete($empresa);

                // primero hay que eliminar el servicio en otras tablas con las que esté relacionada la entidad
               // foreach($valoraciones as $valoracion) {
               //     $em->remove($valoracion);
               // };
               // foreach($solicitudes as $solicitud) {
               //     $em->remove($solicitud);
               // };

                // ya podemos eliminar la entidad
               // $em->remove($servicio);
               // $em->flush();
                $this->addFlash('info', 'Empresa eliminada');
                return $this->redirectToRoute('empresa_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar la empresa');
            }
        }

        return $this->render('empresa/eliminar.html.twig', [
            'empresa' => $empresa
        ]);
    }

}
