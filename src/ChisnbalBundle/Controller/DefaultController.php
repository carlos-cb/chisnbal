<?php

namespace ChisnbalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChisnbalBundle\Entity\Product;

class DefaultController extends Controller
{
    public function indexAction()
    {
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

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Fotodetalle p WHERE p.product=$productId");
        $fotodetalles = $query->getResult();

        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Color p WHERE p.product=$productId");
        $colors = $query->getResult();
        
        
        return $this->render('ChisnbalBundle:Default:productDetalle.html.twig', array(
            'fotodetalles' => $fotodetalles,
            'colors' => $colors,
            'product' => $product,
            'categories' => $categories,
        ));
    }

    public function cartAction()
    {
        return $this->render('ChisnbalBundle:Default:cart.html.twig');
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
