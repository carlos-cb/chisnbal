<?php

namespace ChisnbalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ChisnbalBundle\Entity\OrderInfo;
use ChisnbalBundle\Entity\OrderItem;

class OrderController extends Controller
{
    public function cartToOrderinfoAction(Request $request)
    {
        $priceAll = $this->countAll();
        $priceIni = $priceAll;
        if($request->get('paytype') == '2'){
            $priceAll= round($priceAll*1.21, 2);
        }
        if($request->get('paytype') == '3'){
            $priceAll= round($priceAll*1.05, 2);
        }
        //根据用户填写的表格新建订单
        if($request->getMethod() == 'POST' && ($priceAll!=0) ){
            //订单信息录入
            $orderInfo = new OrderInfo();
            $orderInfo->setUser($this->getUser())
                ->setOrderDate(new \DateTime('now'))
                ->setGoodsFee($priceIni)
                ->setShipFee(0)
                ->setTotalPrice($priceAll)
                ->setPayType($request->get('paytype'))
                ->setReceiverName($request->get('name'))
                ->setReceiverPhone($request->get('phonenumber'))
                ->setReceiverAdress($request->get('address'))
                ->setReceiverCity($request->get('city'))
                ->setReceiverEmail($request->get('email'))
                ->setReceiverPostcode($request->get('postcode'))
                ->setIsConfirmed(true)
                ->setIsSended(false)
                ->setIsOver(false)
                ->setState("Being prepared");

            $em = $this->getDoctrine()->getManager();
            $em->persist($orderInfo);
            $em->flush();

            //将购物车商品全部倒入订单中
            $cleanCart = $this->itemToOrder($orderInfo);

            //清空购物车的所有商品并且状态改为已生成订单
            $this->clearCarrito();

            $cart = $this->getUser()->getCart();
            $cart->setCartState('over');
            $em->flush();
        }else{
            return $this->redirectToRoute('chisnbal_carrito');
        }

        return $this->redirectToRoute('chisnbal_orderclient');  
    }

    private function itemToOrder(OrderInfo $orderInfo)
    {
        $user = $this->getUser();
        $cartItems = $user->getCart()->getCartItems();
        $em = $this->getDoctrine()->getManager();

        foreach($cartItems as $cartItem)
        {
            $orderItem = new OrderItem();
            $orderItem->setQuantity($cartItem->getQuantity())
                ->setOrderInfo($orderInfo)
                ->setUnit($cartItem->getUnit())
                ->setColorId($cartItem->getColorId())
                ->setColorName($cartItem->getColorName())
                ->setFoto($cartItem->getFoto())
                ->setProduct($cartItem->getProduct());
            $orderInfo->addOrderItem($orderItem);

            $em->persist($orderItem);
        }
        $em->flush();
    }

    public function clearCarrito()
    {
        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();

        $em = $this->getDoctrine()->getManager();
        foreach($cartItems as $cartItem){
            $cart->removeCartItem($cartItem);
            $em->remove($cartItem);
        }
        $em->flush();
    }

    private function countAll()
    {
        $user = $this->getUser();
        $cartItems = $user->getCart()->getCartItems();
        $priceall = 0;

        foreach($cartItems as $cartItem)
        {
            $priceall += ($cartItem->getQuantity() * $cartItem->getUnit() * $cartItem->getProduct()->getPrice());
        }
        return $priceall;
    }

    public function orderclientAction()
    {
        $user = $this->getUser();

        $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:OrderInfo');
        $orderInfos = $repository->findByUser($user);

        return $this->render('ChisnbalBundle:Default:orderclient.html.twig', array(
            'orderInfos' => $orderInfos,
        ));
    }
    
    public function productlistclientAction($orderInfoId)
    {
        $em = $this->getDoctrine()->getManager();

        $orderInfo = $this->getOrderInfo($orderInfoId);

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:OrderItem p WHERE p.orderInfo=$orderInfoId");
        $orderItems = $query->getResult();

        return $this->render('ChisnbalBundle:Default:productlistclient.html.twig', array(
            'orderItems' => $orderItems,
            'orderInfo' => $orderInfo,
        ));
    }

    private function getOrderInfo($orderInfoId)
    {
        $orderInfo = $this->getDoctrine()
            ->getRepository('ChisnbalBundle:OrderInfo')
            ->find($orderInfoId);
        return $orderInfo;
    }
}
