<?php

namespace ChisnbalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ChisnbalBundle\Entity\Product;

class SelectController extends Controller
{
    public function selectNewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ChisnbalBundle:Category')->findAll();
        $query = $em->createQuery("SELECT p FROM ChisnbalBundle:Product p WHERE p.isNew=1");
        $products = $query->getResult();
        return $this->render('select/new.html.twig', array(
            'products' => $products,
            'categories' => $categories,
        ));
    }

    public function addNewAction(Request $request)
    {
        $codigo = $request->request->get('codigo');
        $repository = $this->getDoctrine()->getRepository('ChisnbalBundle:Product');
        $product = $repository->findOneByCodigo($codigo);
        if($product){
            if($product->getIsNew()){
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    '该产品已经在新产品列表中'
                );
            }else{
                $product->setIsNew(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    '添加成功'
                );
            }
        }else{
            $this->get('session')->getFlashBag()->add(
                'notice',
                '添加失败，请检查产品编号是否正确'
            );
        }
        return $this->redirectToRoute('select_new');
    }

    public function deleteNewAction(Product $product)
    {
        if($product){
            if(!$product->getIsNew()){
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    '该产品已经从新产品列表中取消'
                );
            }else{
                $product->setIsNew(false);
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();
                $this->get('session')->getFlashBag()->add(
                    'success',
                    '取消成功'
                );
            }
        }else{
            $this->get('session')->getFlashBag()->add(
                'notice',
                '取消失败，请检查产品编号是否正确'
            );
        }
        return $this->redirectToRoute('select_new');
    }
}
