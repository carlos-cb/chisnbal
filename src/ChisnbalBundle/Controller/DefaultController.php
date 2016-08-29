<?php

namespace ChisnbalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChisnbalBundle\Entity\Product;
use ChisnbalBundle\Entity\Cart;

class DefaultController extends Controller
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
        return $this->render('ChisnbalBundle:Default:index.html.twig');
    }
    
    public function backEndAction()
    {
        return $this->render('ChisnbalBundle:BackEnd:overview.html.twig');
    }
    
    public function productListAction($categoryId)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Product p WHERE p.category=$categoryId and (p.isSale=0 or p.isSale='null')");
        $products = $query->getResult();

        return $this->render('ChisnbalBundle:Default:productList.html.twig', array(
            'products' => $products,
            'categories' => $categories,
        ));
    }

    public function productDetalleAction($productId)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $product = $this->getProductInfo($productId);
        
        return $this->render('ChisnbalBundle:Default:productDetalle.html.twig', array(
            'product' => $product,
            'categories' => $categories,
        ));
    }

    public function cartAction()
    {
        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();

        return $this->render('ChisnbalBundle:Default:cart.html.twig', array(
            'cartItems' => $cartItems,
        ));
    }
    
    public function guestinfoAction()
    {
        return $this->render('ChisnbalBundle:Default:guestinfo.html.twig');
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
