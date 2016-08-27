<?php

namespace ChisnbalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FotodetalleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fotodetalle', FileType::class, array(
                'label' => '细节图片',
                'data_class' => null,
                'required' => false,
            ))
            ->add('descriptionEs', 'text', array(
                'label' => '备注西语',
                'required' => false,
            ))
            ->add('descriptionEn', 'text', array(
                'label' => '备注英语',
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
            'data_class' => 'ChisnbalBundle\Entity\Fotodetalle'
        ));
    }
}
