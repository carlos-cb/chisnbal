<?php

namespace ChisnbalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productNameEs', 'text', array('label' => '产品名西语'))
            ->add('productNameEn', 'text', array('label' => '产品名英语'))
            ->add('category', null, array(
                'label' => '所属分类',
                'class' => 'ChisnbalBundle:Category',
                'property' => 'categoryNameEs',
            ))
            ->add('price', null, array(
                'label' => '单价',
                'required' => false,
            ))
            ->add('codigo', 'text', array('label' => '产品编号'))
            ->add('foto', FileType::class, array(
                'label' => '图片',
                'data_class' => null,
                'required' => false,
            ))
            ->add('description', 'text', array(
                'label' => '备注',
                'required' => false,
            ))
            ->add('isHunzhuang', CheckboxType::class, array(
                'label'    => '是否全颜色混装',
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChisnbalBundle\Entity\Product'
        ));
    }
}
