<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\FontProduct;
use ChisnbalBundle\Form\FontProductType;

/**
 * FontProduct controller.
 *
 */
class FontProductController extends Controller
{
    /**
     * Lists all FontProduct entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fontProducts = $em->getRepository('ChisnbalBundle:FontProduct')->findAll();

        return $this->render('fontproduct/index.html.twig', array(
            'fontProducts' => $fontProducts,
        ));
    }

    /**
     * Creates a new FontProduct entity.
     *
     */
    public function newAction(Request $request)
    {
        $fontProduct = new FontProduct();
        $form = $this->createForm('ChisnbalBundle\Form\FontProductType', $fontProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fontProduct->getFoto();
            $fileName = $this->get('chisnbal.foto_uploader')->upload($file);
            $fontProduct->setFoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($fontProduct);
            $em->flush();

            return $this->redirectToRoute('fontproduct_show', array('id' => $fontProduct->getId()));
        }

        return $this->render('fontproduct/new.html.twig', array(
            'fontProduct' => $fontProduct,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FontProduct entity.
     *
     */
    public function showAction(FontProduct $fontProduct)
    {
        $deleteForm = $this->createDeleteForm($fontProduct);

        return $this->render('fontproduct/show.html.twig', array(
            'fontProduct' => $fontProduct,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FontProduct entity.
     *
     */
    public function editAction(Request $request, FontProduct $fontProduct)
    {
        $fileOld = $fontProduct->getFoto();
        $deleteForm = $this->createDeleteForm($fontProduct);
        $editForm = $this->createForm('ChisnbalBundle\Form\FontProductType', $fontProduct);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $fontProduct->getFoto();
            if($file != $fileOld)
            {
                $isRemoved = $this->get('chisnbal.foto_uploader')->remove($fileOld);
                if($isRemoved){
                    $fileName = $this->get('chisnbal.foto_uploader')->upload($file);
                    $fontProduct->setFoto($fileName);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($fontProduct);
            $em->flush();

            return $this->redirectToRoute('fontproduct_index');
        }

        return $this->render('fontproduct/edit.html.twig', array(
            'fontProduct' => $fontProduct,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FontProduct entity.
     *
     */
    public function deleteAction(Request $request, FontProduct $fontProduct)
    {
        $form = $this->createDeleteForm($fontProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fontProduct);
            $em->flush();
        }

        return $this->redirectToRoute('fontproduct_index');
    }

    /**
     * Creates a form to delete a FontProduct entity.
     *
     * @param FontProduct $fontProduct The FontProduct entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FontProduct $fontProduct)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fontproduct_delete', array('id' => $fontProduct->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
