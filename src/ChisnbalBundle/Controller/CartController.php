<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\Cart;
use ChisnbalBundle\Form\CartType;

/**
 * Cart controller.
 *
 */
class CartController extends Controller
{
    /**
     * Lists all Cart entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carts = $em->getRepository('ChisnbalBundle:Cart')->findAll();

        return $this->render('cart/index.html.twig', array(
            'carts' => $carts,
        ));
    }

    /**
     * Creates a new Cart entity.
     *
     */
    public function newAction(Request $request)
    {
        $cart = new Cart();
        $form = $this->createForm('ChisnbalBundle\Form\CartType', $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cart);
            $em->flush();

            return $this->redirectToRoute('cart_show', array('id' => $cart->getId()));
        }

        return $this->render('cart/new.html.twig', array(
            'cart' => $cart,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cart entity.
     *
     */
    public function showAction(Cart $cart)
    {
        $deleteForm = $this->createDeleteForm($cart);

        return $this->render('cart/show.html.twig', array(
            'cart' => $cart,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cart entity.
     *
     */
    public function editAction(Request $request, Cart $cart)
    {
        $deleteForm = $this->createDeleteForm($cart);
        $editForm = $this->createForm('ChisnbalBundle\Form\CartType', $cart);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cart);
            $em->flush();

            return $this->redirectToRoute('cart_edit', array('id' => $cart->getId()));
        }

        return $this->render('cart/edit.html.twig', array(
            'cart' => $cart,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cart entity.
     *
     */
    public function deleteAction(Request $request, Cart $cart)
    {
        $form = $this->createDeleteForm($cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cart);
            $em->flush();
        }

        return $this->redirectToRoute('cart_index');
    }

    /**
     * Creates a form to delete a Cart entity.
     *
     * @param Cart $cart The Cart entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cart $cart)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cart_delete', array('id' => $cart->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
