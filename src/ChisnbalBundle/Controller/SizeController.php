<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\Size;
use ChisnbalBundle\Form\SizeType;

/**
 * Size controller.
 *
 */
class SizeController extends Controller
{
    /**
     * Lists all Size entities.
     *
     */
    public function indexAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        //获取产品信息
        $product = $this->getProductInfo($productId);
        
        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Size p WHERE p.product=$productId");
        $sizes = $query->getResult();

        return $this->render('size/index.html.twig', array(
            'sizes' => $sizes,
            'product' => $product
        ));
    }

    /**
     * Creates a new Size entity.
     *
     */
    public function newAction(Request $request, $productId)
    {
        $size = new Size();
        $product = $this->getProductInfo($productId);
        $size->setProduct($product);
        $form = $this->createForm('ChisnbalBundle\Form\SizeType', $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($size);
            $em->flush();

            return $this->redirectToRoute('size_index', array('productId' => $productId));
        }

        return $this->render('size/new.html.twig', array(
            'size' => $size,
            'form' => $form->createView(),
            'product' => $product,
        ));
    }

    /**
     * Finds and displays a Size entity.
     *
     */
    public function showAction(Size $size)
    {
        $deleteForm = $this->createDeleteForm($size);

        return $this->render('size/show.html.twig', array(
            'size' => $size,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Size entity.
     *
     */
    public function editAction(Request $request, Size $size, $productId)
    {
        $deleteForm = $this->createDeleteForm($size);
        $editForm = $this->createForm('ChisnbalBundle\Form\SizeType', $size);
        $editForm->handleRequest($request);
        $product = $this->getProductInfo($productId);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($size);
            $em->flush();

            return $this->redirectToRoute('size_index', array('productId' => $productId));
        }

        return $this->render('size/edit.html.twig', array(
            'size' => $size,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'product' => $product,
        ));
    }

    /**
     * Deletes a Size entity.
     *
     */
    public function deleteAction(Request $request, Size $size)
    {
        $productId = $size->getProduct();
        $form = $this->createDeleteForm($size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($size);
            $em->flush();
        }

        return $this->redirectToRoute('size_index', array(
            'productId' => $productId,
        ));
    }

    /**
     * Creates a form to delete a Size entity.
     *
     * @param Size $size The Size entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Size $size)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('size_delete', array('id' => $size->getId())))
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

    public function sizeAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sizeName = $request->request->get('codigo');
        $num = $request->request->get('price');
        $productId = $request->request->get('id');
        $product = $this->getProductInfo($productId);
        
        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Size p WHERE p.product=$productId and p.sizeName='$sizeName'");
        $size = $query->getResult();
        
        if($size){
            $this->get('session')->getFlashBag()->add(
                'notice',
                '该尺码已经在列表中');
        }else{
            $newSize = new Size();
            $newSize->setSizeName($sizeName)
                    ->setQuantity($num)
                    ->setProduct($product);
            
            $em->persist($newSize);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                '添加成功'
            );
        }
        return $this->redirectToRoute('size_index', array('productId' => $productId));
    }
}
