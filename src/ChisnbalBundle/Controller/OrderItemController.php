<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\OrderItem;
use ChisnbalBundle\Form\OrderItemType;

/**
 * OrderItem controller.
 *
 */
class OrderItemController extends Controller
{
    /**
     * Lists all OrderItem entities.
     *
     */
    public function indexAction($orderInfoId)
    {
        $em = $this->getDoctrine()->getManager();

        $orderInfo = $this->getOrderInfo($orderInfoId);

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:OrderItem p WHERE p.orderInfo=$orderInfoId");
        $orderItems = $query->getResult();

        return $this->render('orderitem/index.html.twig', array(
            'orderItems' => $orderItems,
            'orderInfo' => $orderInfo,
        ));
    }

    /**
     * Creates a new OrderItem entity.
     *
     */
    public function newAction(Request $request)
    {
        $orderItem = new OrderItem();
        $form = $this->createForm('ChisnbalBundle\Form\OrderItemType', $orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderItem);
            $em->flush();

            return $this->redirectToRoute('orderitem_show', array('id' => $orderItem->getId()));
        }

        return $this->render('orderitem/new.html.twig', array(
            'orderItem' => $orderItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrderItem entity.
     *
     */
    public function showAction(OrderItem $orderItem)
    {
        $deleteForm = $this->createDeleteForm($orderItem);

        return $this->render('orderitem/show.html.twig', array(
            'orderItem' => $orderItem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrderItem entity.
     *
     */
    public function editAction(Request $request, OrderItem $orderItem)
    {
        $deleteForm = $this->createDeleteForm($orderItem);
        $editForm = $this->createForm('ChisnbalBundle\Form\OrderItemType', $orderItem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderItem);
            $em->flush();

            return $this->redirectToRoute('orderitem_edit', array('id' => $orderItem->getId()));
        }

        return $this->render('orderitem/edit.html.twig', array(
            'orderItem' => $orderItem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrderItem entity.
     *
     */
    public function deleteAction(Request $request, OrderItem $orderItem)
    {
        $form = $this->createDeleteForm($orderItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderItem);
            $em->flush();
        }

        return $this->redirectToRoute('orderitem_index');
    }

    /**
     * Creates a form to delete a OrderItem entity.
     *
     * @param OrderItem $orderItem The OrderItem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrderItem $orderItem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderitem_delete', array('id' => $orderItem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    private function getOrderInfo($orderInfoId)
    {
        $orderInfo = $this->getDoctrine()
            ->getRepository('ChisnbalBundle:OrderInfo')
            ->find($orderInfoId);
        return $orderInfo;
    }
}
