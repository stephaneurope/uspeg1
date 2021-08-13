<?php

namespace App\Form;

use App\Entity\PropertySearchNameCheque4;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PropertySearchNameCheque4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name4',TextType::class, [
                'required' => false,
                'label'    => false,
                'attr'     => [
                    'placeholder' => "vérifier si le nom inscrit sur le chèque est enregistré dans le versement 4"
                ]
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => PropertySearchNameCheque4::class,
            'method'          => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}