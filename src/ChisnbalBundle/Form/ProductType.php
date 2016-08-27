<?php

namespace ChisnbalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('size', 'choice', array(
                'choices' => array(
                    'Única' => 'Única',
                    'XS' => 'XS',
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                    'XXL' => 'XXL',
                ),
                'label' => '尺寸',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ))
            ->add('description', 'text', array(
                'label' => '备注',
                'required' => false,
            ))
            ->add('unit', null, array('label' => '单位'))
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
