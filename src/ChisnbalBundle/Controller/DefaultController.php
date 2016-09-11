<?php

namespace ChisnbalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChisnbalBundle\Entity\Product;
use ChisnbalBundle\Entity\Cart;
use ChisnbalBundle\Entity\CartItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function quiensomosAction()
    {
        return $this->render('ChisnbalBundle:Default:quiensomos.html.twig');
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

    public function productListNewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Product p WHERE p.isNew=1");
        $products = $query->getResult();
        return $this->render('ChisnbalBundle:Default:new.html.twig', array(
            'products' => $products,
            'categories' => $categories,
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
        
        return $this->render('ChisnbalBundle:Default:productDetalle.html.twig', array(
            'product' => $product,
            'categories' => $categories,
            'numItems' => $numItems,
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

    public function addToCartAction(Request $request)
    {
        $cart = $this->getUser()->getCart();
        $em = $this->getDoctrine()->getManager();

        //获取ajax参数
        $productid = $request->get('id');
        $productunit = $request->get('unit');
        $colors = $request->get('info');

        //获取product实体
        $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:Product');
        $product = $repository->find($productid);

        foreach($colors as $color){
            $exsiteColor = $this->getDoctrine()->getRepository('ChisnbalBundle:CartItem')->findOneBy(array('cart' => $cart, 'product' => $product, 'color' => $color));
            if($exsiteColor)
            {
                $exsiteColor->setQuantity($exsiteColor->getQuantity()+1);
                $em->persist($exsiteColor);
                $em->flush();
            }else
            {
                $newCartItem = new CartItem();
                $newCartItem->setCart($cart)->setProduct($product)->setQuantity(1)->setUnit($productunit)->setColor($color);
                $cart->addCartItem($newCartItem);
                $em->persist($newCartItem);
                $em->flush();
            }
        }
        return $this->render('ChisnbalBundle:Default:guestinfo.html.twig');
    }
}
