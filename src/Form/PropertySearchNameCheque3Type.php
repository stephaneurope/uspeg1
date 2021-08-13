<?php

namespace App\Form;

use App\Entity\PropertySearchNameCheque3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PropertySearchNameCheque3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name3',TextType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'placeholder' => "vérifier si le nom inscrit sur le chèque est enregistré dans le versement 3"
                ]
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => PropertySearchNameCheque3::class,
            'method'          => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}