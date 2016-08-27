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
    public function indexAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        //获取产品信息
        $product = $this->getProductInfo($productId);

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Fotodetalle p WHERE p.product=$productId");
        $fotodetalles = $query->getResult();

        return $this->render('fotodetalle/index.html.twig', array(
            'fotodetalles' => $fotodetalles,
            'product' => $product,
        ));
    }

    /**
     * Creates a new Fotodetalle entity.
     *
     */
    public function newAction(Request $request, $productId)
    {
        $fotodetalle = new Fotodetalle();
        $product = $this->getProductInfo($productId);
        $fotodetalle->setProduct($product);
        $form = $this->createForm('ChisnbalBundle\Form\FotodetalleType', $fotodetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fotodetalle->getFotodetalle();
            $fileName = $this->get('chisnbal.foto_uploader')->upload($file);
            $fotodetalle->setFotodetalle($fileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($fotodetalle);
            $em->flush();

            return $this->redirectToRoute('fotodetalle_index', array('productId' => $productId));
        }

        return $this->render('fotodetalle/new.html.twig', array(
            'fotodetalle' => $fotodetalle,
            'form' => $form->createView(),
            'product' => $product,
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
    public function editAction(Request $request, Fotodetalle $fotodetalle, $productId)
    {
        $fileOld = $fotodetalle->getFotodetalle();
        $deleteForm = $this->createDeleteForm($fotodetalle);
        $editForm = $this->createForm('ChisnbalBundle\Form\FotodetalleType', $fotodetalle);
        $editForm->handleRequest($request);
        $product = $this->getProductInfo($productId);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $fotodetalle->getFotodetalle();
            if($file != $fileOld)
            {
                $isRemoved = $this->get('chisnbal.foto_uploader')->remove($fileOld);
                if($isRemoved){
                    $fileName = $this->get('chisnbal.foto_uploader')->upload($file);
                    $fotodetalle->setFotodetalle($fileName);
                }
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($fotodetalle);
            $em->flush();

            return $this->redirectToRoute('fotodetalle_index', array('productId' => $productId));
        }

        return $this->render('fotodetalle/edit.html.twig', array(
            'fotodetalle' => $fotodetalle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'product' => $product,
        ));
    }

    /**
     * Deletes a Fotodetalle entity.
     *
     */
    public function deleteAction(Request $request, Fotodetalle $fotodetalle)
    {
        $productId = $fotodetalle->getProduct();
        $form = $this->createDeleteForm($fotodetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $fotodetalle->getFotodetalle();
            if($file){
                $isRemoved = $this->get('chisnbal.foto_uploader')->remove($file);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($fotodetalle);
            $em->flush();
        }

        return $this->redirectToRoute('fotodetalle_index', array(
            'productId' => $productId,
        ));
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

    private function getProductInfo($productId)
    {
        //获取产品信息
        $product = $this->getDoctrine()
            ->getRepository('ChisnbalBundle:Product')
            ->findOneById($productId);
        return $product;
    }
}
