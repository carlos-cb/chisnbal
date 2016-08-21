<?php

namespace ChisnbalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productNameEs')
            ->add('productNameEn')
            ->add('price')
            ->add('codigo')
            ->add('description')
            ->add('foto')
            ->add('size')
            ->add('isSale')
            ->add('discountPrice')
            ->add('isNew')
            ->add('unit')
            ->add('stock')
            ->add('category')
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
