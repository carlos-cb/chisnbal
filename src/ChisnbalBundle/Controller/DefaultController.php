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
        $fontProducts = $em->getRepository('ChisnbalBundle:FontProduct')->findAll();
        
        return $this->render('ChisnbalBundle:Default:index.html.twig', array(
            'fontProducts' => $fontProducts,
        ));
    }

    public function quiensomosAction()
    {
        return $this->render('ChisnbalBundle:Default:quiensomos.html.twig');
    }

    public function backEndAction()
    {
        $em = $this->getDoctrine()->getManager();

        $numUser = $em->getRepository('ChisnbalBundle:User')->createQueryBuilder('a')->select('COUNT(a.id)')->getQuery()->getSingleScalarResult();
        $numOrder = $em->getRepository('ChisnbalBundle:OrderInfo')->createQueryBuilder('b')->select('COUNT(b.id)')->getQuery()->getSingleScalarResult();
        $numProduct = $em->getRepository('ChisnbalBundle:Product')->createQueryBuilder('c')->select('COUNT(c.id)')->getQuery()->getSingleScalarResult();
        $numCategory = $em->getRepository('ChisnbalBundle:Category')->createQueryBuilder('d')->select('COUNT(d.id)')->getQuery()->getSingleScalarResult();

        $queryU = $em->createQuery("SELECT p FROM ChisnbalBundle:User p WHERE 1=1 order by p.id DESC")->setMaxResults(10);
        $users = $queryU->getResult();

        $queryO = $em->createQuery("SELECT t FROM ChisnbalBundle:OrderInfo t WHERE 1=1 order by t.id DESC")->setMaxResults(10);
        $orders = $queryO->getResult();

        $day6Orders = array();
        for($i=0; $i<6; $i++){
            $queryday6Orders[$i] = $em->createQuery("SELECT COUNT(o) FROM ChisnbalBundle:OrderInfo o where o.orderDate <= DATE_ADD(CURRENT_DATE(), (1-$i), 'day') and o.orderDate >= DATE_SUB(CURRENT_DATE(), $i, 'day')");
            $day6Orders[$i] = $queryday6Orders[$i]->getSingleScalarResult();
        }

        return $this->render('ChisnbalBundle:BackEnd:overview.html.twig', array(
            'numUser' => $numUser,
            'numOrder' => $numOrder,
            'numProduct' => $numProduct,
            'numCategory' => $numCategory,
            'users' => $users,
            'orders' => $orders,
            'day6Orders' => $day6Orders,
        ));
    }
    
    public function productListAction($categoryId)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Product p WHERE p.category=$categoryId and p.isShow=1");
        $products = $query->getResult();

        if(!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();
        $numItems = count($cartItems);

        return $this->render('ChisnbalBundle:Default:productList.html.twig', array(
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

        if(!$this->getUser()){
            return $this->redirectToRoute('fos_user_security_login');
        }
        $cart = $this->getUser()->getCart();
        $cartItems = $cart->getCartItems();
        $numItems = count($cartItems);

        return $this->render('ChisnbalBundle:Default:new.html.twig', array(
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
        $priceall = $this->countAll();
        return $this->render('ChisnbalBundle:Default:guestinfo.html.twig', array(
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

    public function addToCartAction(Request $request)
    {
        $cart = $this->getUser()->getCart();
        $em = $this->getDoctrine()->getManager();

        //获取ajax参数
        $productid = $request->get('id');
        $productunit = $request->get('unit');
        $colorIds = $request->get('info');

        //获取product实体
        $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:Product');
        $product = $repository->find($productid);
        

        foreach($colorIds as $colorId){
            $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:Color');
            $colorshiti = $repository->find($colorId);
            $exsiteColor = $this->getDoctrine()->getRepository('ChisnbalBundle:CartItem')->findOneBy(array('cart' => $cart, 'product' => $product, 'colorId' => $colorId));
            
            if($exsiteColor)
            {
                $exsiteColor->setQuantity($exsiteColor->getQuantity()+1);
                $em->persist($exsiteColor);
                $em->flush();
            }else
            {
                $newCartItem = new CartItem();
                $newCartItem->setCart($cart)
                            ->setProduct($product)
                            ->setQuantity(1)
                            ->setUnit($productunit)
                            ->setColorId($colorId)
                            ->setColorName($colorshiti->getColorNameEs())
                            ->setFoto($colorshiti->getColorFoto());
                $cart->addCartItem($newCartItem);
                $em->persist($newCartItem);
                $em->flush();
            }
        }
        return new Response();
    }

    public function addToCartHunzhuangAction(Request $request)
    {
        $cart = $this->getUser()->getCart();
        $em = $this->getDoctrine()->getManager();

        //获取ajax参数
        $productid = $request->get('id');
        $productunit = $request->get('unit');
        $hunzhuang = $request->get('color');

        //获取product实体
        $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:Product');
        $product = $repository->find($productid);

            $exsiteColor = $this->getDoctrine()->getRepository('ChisnbalBundle:CartItem')->findOneBy(array('cart' => $cart, 'product' => $product));

            if($exsiteColor)
            {
                $exsiteColor->setQuantity($exsiteColor->getQuantity()+1);
                $em->persist($exsiteColor);
                $em->flush();
            }else
            {
                $newCartItem = new CartItem();
                $newCartItem->setCart($cart)
                    ->setProduct($product)
                    ->setQuantity(1)
                    ->setUnit($productunit)
                    ->setColorId(0)
                    ->setColorName($hunzhuang)
                    ->setFoto($product->getFoto());
                $cart->addCartItem($newCartItem);
                $em->persist($newCartItem);
                $em->flush();
            }
        return new Response();
    }
}
