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
        $confiRedes = $this->getDoctrine()->getRepository('AppBundle:ConfiRed')->findAll();

        return $this->render('confired/listar.html.twig', [
            'confiRedes' => $confiRedes
        ]);
    }

    /**
     * @Route("/confired/nueva/{id}", name="confired_nueva")
     * @Route("/confired/nueva", name="confired_crear")
     * @Security("is_granted('CONFIRED_CREAR')")
     */
    public function crearAction(Request $request, Empresa $empresa = null)
    {
        $em = $this->getDoctrine()->getManager();

        $tengoEmpresa = false;

        $confiRed = new ConfiRed();

        if (null !== $empresa) { // si tengo la empresa, se la asigno
            $tengoEmpresa = true;
            $confiRed->setEmpresa($empresa);
        }

        $em->persist($confiRed);

        $form = $this->createForm(ConfiRedType::class, $confiRed, [
            'tengoEmpresa' => $tengoEmpresa
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            if (true === $tengoEmpresa){
                return $this->redirectToRoute('empresa_servicios_mostrar', [
                    'id' => $empresa->getId()
                ]);
            } else {
                return $this->redirectToRoute('confired_listar');
                // redirige a esta y con errores, pero en realidad se guardan
            }
        }

        return $this->render('confired/form.html.twig', [
            'confiRed' => $confiRed,
            'empresa' => $empresa,
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
                $this->addFlash('info', 'Configuración eliminada');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar la configuración');
            }
            return $this->redirectToRoute('confired_listar');
        }

        return $this->render('confired/eliminar.html.twig', [
            'confiRed' => $confiRed
        ]);
    }

    /**
     * @Route("/confired/editar/{id}", name="confired_editar")
     * @Security("is_granted('CONFIRED_EDITAR', confiRed)")
     */
    public function editarAction(Request $request, ConfiRed $confiRed)
    {
        $em = $this->getDoctrine()->getManager();

        $tengoEmpresa = true;

        $em->persist($confiRed);

        $form = $this->createForm(ConfiRedType::class, $confiRed, [
            'tengoEmpresa' => $tengoEmpresa
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('confired_listar');
        }

        return $this->render('confired/form.html.twig', [
            'confiRed' => $confiRed,
            'formulario' => $form->createView()
        ]);
    }


}
