<?php

namespace ChisnbalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ChisnbalBundle\Entity\OrderInfo;
use ChisnbalBundle\Form\OrderInfoType;

/**
 * OrderInfo controller.
 *
 */
class OrderInfoController extends Controller
{
    /**
     * Lists all OrderInfo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orderInfos = $em->getRepository('ChisnbalBundle:OrderInfo')->findAll();

        return $this->render('orderinfo/index.html.twig', array(
            'orderInfos' => $orderInfos,
        ));
    }

    /**
     * Creates a new OrderInfo entity.
     *
     */
    public function newAction(Request $request)
    {
        $orderInfo = new OrderInfo();
        $form = $this->createForm('ChisnbalBundle\Form\OrderInfoType', $orderInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderInfo);
            $em->flush();

            return $this->redirectToRoute('orderinfo_show', array('id' => $orderInfo->getId()));
        }

        return $this->render('orderinfo/new.html.twig', array(
            'orderInfo' => $orderInfo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrderInfo entity.
     *
     */
    public function showAction(OrderInfo $orderInfo)
    {
        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($orderInfo);

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:OrderItem p WHERE p.orderInfo=$orderInfo");
        $orderItems = $query->getResult();

        return $this->render('orderinfo/show.html.twig', array(
            'orderInfo' => $orderInfo,
            'orderItems' => $orderItems,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrderInfo entity.
     *
     */
    public function editAction(Request $request, OrderInfo $orderInfo)
    {
        $deleteForm = $this->createDeleteForm($orderInfo);
        $editForm = $this->createForm('ChisnbalBundle\Form\OrderInfoType', $orderInfo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderInfo);
            $em->flush();

            return $this->redirectToRoute('orderinfo_edit', array('id' => $orderInfo->getId()));
        }

        return $this->render('orderinfo/edit.html.twig', array(
            'orderInfo' => $orderInfo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrderInfo entity.
     *
     */
    public function deleteAction(Request $request, OrderInfo $orderInfo)
    {
        $form = $this->createDeleteForm($orderInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderInfo);
            $em->flush();
        }

        return $this->redirectToRoute('orderinfo_index');
    }

    /**
     * Creates a form to delete a OrderInfo entity.
     *
     * @param OrderInfo $orderInfo The OrderInfo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrderInfo $orderInfo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderinfo_delete', array('id' => $orderInfo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deliveredAction(Request $request)
    {
        if($request->getMethod() == 'POST'){
            $em = $this->getDoctrine()->getManager();

            $orderInfoId = $request->get('orderInfoId');
            $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:OrderInfo');
            $orderInfo = $repository->find($orderInfoId);

            $orderInfo->setIsSended(1)
                      ->setState("Delivered")
                      ->setEnvio($request->get('numeroEnvio'));
            $em->persist($orderInfo);
            $em->flush();
        }
        return $this->redirectToRoute('orderinfo_index');
    }

    public function successAction(OrderInfo $orderInfo)
    {
        $em = $this->getDoctrine()->getManager();
        $orderInfo->setIsOver(1)->setState("Success");
        $em->persist($orderInfo);
        $em->flush();

        return $this->redirectToRoute('orderinfo_index');
    }

    public function cancelledAction(OrderInfo $orderInfo)
    {
        $em = $this->getDoctrine()->getManager();
        $orderInfo->setIsOver(1)->setState("Cancelled");
        $em->persist($orderInfo);
        $em->flush();

        return $this->redirectToRoute('orderinfo_index');
    }
}
