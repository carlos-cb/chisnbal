<?php

namespace ChisnbalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChisnbalBundle\Entity\Product;
use ChisnbalBundle\Entity\Cart;
use ChisnbalBundle\Entity\CartItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultEnController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cart = $this->getUser()->getCart();
        if(!$cart) {
            $cart = new Cart();
            $cart->setCartState('buying')
                ->setCreateDate(new \DateTime('now'))
                ->setUser($this->getUser());
            $em->persist($cart);
            $em->flush();
        }
        else if($cart->getCartState() == 'over')
        {
            $cart->setCartState('buying')
                ->setCreateDate(new \DateTime('now'));
            $em->persist($cart);
            $em->flush();
        }
        
        return $this->render('ChisnbalBundle:DefaultEn:index.html.twig');
    }

    public function quiensomosAction()
    {
        return $this->render('ChisnbalBundle:DefaultEn:quiensomos.html.twig');
    }
    
    public function productListAction($categoryId)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Product p WHERE p.category=$categoryId and p.isShow=1");
        $products = $query->getResult();

        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();
        $numItems = count($cartItems);

        return $this->render('ChisnbalBundle:DefaultEn:productList.html.twig', array(
            'products' => $products,
            'categories' => $categories,
            'numItems' => $numItems,
        ));
    }

    public function productListNewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Product p WHERE p.isNew=1 and p.isShow=1");
        $products = $query->getResult();

        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();
        $numItems = count($cartItems);

        return $this->render('ChisnbalBundle:DefaultEn:new.html.twig', array(
            'products' => $products,
            'categories' => $categories,
            'numItems' => $numItems,
        ));
    }

    public function productDetalleAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $product = $this->getProductInfo($productId);

        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();
        $numItems = count($cartItems);
        
        return $this->render('ChisnbalBundle:DefaultEn:productDetalle.html.twig', array(
            'product' => $product,
            'categories' => $categories,
            'numItems' => $numItems,
        ));
    }

    public function cartAction()
    {
        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();

        return $this->render('ChisnbalBundle:DefaultEn:cart.html.twig', array(
            'cartItems' => $cartItems,
        ));
    }

    public function ajaxUpdateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $isAdd = $request->get('val1');
        $cartItemId = $request->get('val2');
        $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:CartItem');
        $cartItem = $repository->find($cartItemId);
        $cartItem->setQuantity($cartItem->getQuantity()+$isAdd);
        $em->persist($cartItem);
        $em->flush();
        return new Response();
    }
    
    public function guestinfoAction()
    {
        $priceall = $this->countAll();
        return $this->render('ChisnbalBundle:DefaultEn:guestinfo.html.twig', array(
            'priceall' => $priceall,
        ));
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

    private function getProductInfo($productId)
    {
        //获取产品信息
        $product = $this->getDoctrine()
            ->getRepository('ChisnbalBundle:Product')
            ->findOneById($productId);
        return $product;
    }

}
