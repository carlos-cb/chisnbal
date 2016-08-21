<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\Fotodetalle;
use ChisnbalBundle\Form\FotodetalleType;

/**
 * Fotodetalle controller.
 *
 */
class FotodetalleController extends Controller
{
    /**
     * Lists all Fotodetalle entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fotodetalles = $em->getRepository('ChisnbalBundle:Fotodetalle')->findAll();

        return $this->render('fotodetalle/index.html.twig', array(
            'fotodetalles' => $fotodetalles,
        ));
    }

    /**
     * Creates a new Fotodetalle entity.
     *
     */
    public function newAction(Request $request)
    {
        $fotodetalle = new Fotodetalle();
        $form = $this->createForm('ChisnbalBundle\Form\FotodetalleType', $fotodetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fotodetalle);
            $em->flush();

            return $this->redirectToRoute('fotodetalle_show', array('id' => $fotodetalle->getId()));
        }

        return $this->render('fotodetalle/new.html.twig', array(
            'fotodetalle' => $fotodetalle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Fotodetalle entity.
     *
     */
    public function showAction(Fotodetalle $fotodetalle)
    {
        $deleteForm = $this->createDeleteForm($fotodetalle);

        return $this->render('fotodetalle/show.html.twig', array(
            'fotodetalle' => $fotodetalle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Fotodetalle entity.
     *
     */
    public function editAction(Request $request, Fotodetalle $fotodetalle)
    {
        $deleteForm = $this->createDeleteForm($fotodetalle);
        $editForm = $this->createForm('ChisnbalBundle\Form\FotodetalleType', $fotodetalle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fotodetalle);
            $em->flush();

            return $this->redirectToRoute('fotodetalle_edit', array('id' => $fotodetalle->getId()));
        }

        return $this->render('fotodetalle/edit.html.twig', array(
            'fotodetalle' => $fotodetalle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Fotodetalle entity.
     *
     */
    public function deleteAction(Request $request, Fotodetalle $fotodetalle)
    {
        $form = $this->createDeleteForm($fotodetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fotodetalle);
            $em->flush();
        }

        return $this->redirectToRoute('fotodetalle_index');
    }

    /**
     * Creates a form to delete a Fotodetalle entity.
     *
     * @param Fotodetalle $fotodetalle The Fotodetalle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fotodetalle $fotodetalle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fotodetalle_delete', array('id' => $fotodetalle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
