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
    
    public function productListAction()
    {
        return $this->render('ChisnbalBundle:Default:productList.html.twig');
    }

    public function productDetalleAction()
    {
        return $this->render('ChisnbalBundle:Default:productDetalle.html.twig');
    }

    public function cartAction()
    {
        return $this->render('ChisnbalBundle:Default:cart.html.twig');
    }
    
    public function guestinfoAction()
    {
        return $this->render('ChisnbalBundle:Default:guestinfo.html.twig');
    }
}
