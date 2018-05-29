<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Servidor;
use AppBundle\Form\Type\ServidorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServidorController extends Controller
{
    /**
     * @Route("/servidores", name="servidor_listar")
     */
    public function listarAction()
    {
        $servidores = $this->getDoctrine()->getRepository('AppBundle:Servidor')->findAll();

        return $this->render('servidor/listar.html.twig', [
            'servidores' => $servidores
        ]);
    }

    /**
     * @Route("/servidor/editar/nuevo", name="servidor_nuevo")
     * @Route("/servidor/editar/{id}", name="servidor_editar")
     */
    public function crearAction(Request $request, Servidor $servidor = null)
    {
        $em = $this->getDoctrine()->getManager();

        $nuevo = false;

        if (null === $servidor) {
            $nuevo = true;
            $servidor = new Servidor();
            $em->persist($servidor);
        }

        $form = $this->createForm(ServidorType::class, $servidor, [
            'nuevo' => $nuevo,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('info', 'Cambios guardados');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
            return $this->redirectToRoute('servidor_listar');
        }

        return $this->render('servidor/form.html.twig', [
            'servidor' => $servidor,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/servidor/eliminar/{id}", name="servidor_eliminar")
     */
    public function eliminarAction(Request $request, Servidor $servidor)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->remove($servidor);
                $em->flush();
                $this->addFlash('info', 'El servidor ha sido eliminado');
            } catch (\Exception $e) {
                $this->addFlash('error', 'No se ha podido eliminar el servidor');
            }
            return $this->redirectToRoute('servidor_listar');
        }

        return $this->render('servidor/eliminar.html.twig', [
            'servidor' => $servidor
        ]);
    }
}
