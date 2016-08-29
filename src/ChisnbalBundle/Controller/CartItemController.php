<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\CartItem;
use ChisnbalBundle\Form\CartItemType;

/**
 * CartItem controller.
 *
 */
class CartItemController extends Controller
{
    /**
     * Lists all CartItem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cartItems = $em->getRepository('ChisnbalBundle:CartItem')->findAll();

        return $this->render('cartitem/index.html.twig', array(
            'cartItems' => $cartItems,
        ));
    }

    /**
     * Creates a new CartItem entity.
     *
     */
    public function newAction(Request $request)
    {
        $cartItem = new CartItem();
        $form = $this->createForm('ChisnbalBundle\Form\CartItemType', $cartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cartItem);
            $em->flush();

            return $this->redirectToRoute('cartitem_show', array('id' => $cartItem->getId()));
        }

        return $this->render('cartitem/new.html.twig', array(
            'cartItem' => $cartItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CartItem entity.
     *
     */
    public function showAction(CartItem $cartItem)
    {
        $deleteForm = $this->createDeleteForm($cartItem);

        return $this->render('cartitem/show.html.twig', array(
            'cartItem' => $cartItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CartItem entity.
     *
     */
    public function editAction(Request $request, CartItem $cartItem)
    {
        $deleteForm = $this->createDeleteForm($cartItem);
        $editForm = $this->createForm('ChisnbalBundle\Form\CartItemType', $cartItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cartItem);
            $em->flush();

            return $this->redirectToRoute('cartitem_edit', array('id' => $cartItem->getId()));
        }

        return $this->render('cartitem/edit.html.twig', array(
            'cartItem' => $cartItem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CartItem entity.
     *
     */
    public function deleteAction(Request $request, CartItem $cartItem)
    {
        $form = $this->createDeleteForm($cartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cartItem);
            $em->flush();
        }

        return $this->redirectToRoute('cartitem_index');
    }

    /**
     * Deletes a CartItem entity.
     *
     */
    public function cartdeleteAction(CartItem $cartItem)
    {
        $cart = $this->getUser()->getCart();
        $cart->removeCartItem($cartItem);

        $em = $this->getDoctrine()->getManager();
        $em->remove($cartItem);
        $em->flush();

        return $this->redirectToRoute('chisnbal_carrito');
    }

    /**
     * Creates a form to delete a CartItem entity.
     *
     * @param CartItem $cartItem The CartItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CartItem $cartItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cartitem_delete', array('id' => $cartItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
