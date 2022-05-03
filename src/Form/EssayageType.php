<?php

namespace App\Form;

use App\Entity\Essayage;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class EssayageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('essaie', CheckboxType::class, [
                'label_attr' => ['class' => 'switch-custom'],
                'label' => 'Essayage',
                'attr'       => ['label'    => 'Essayage'],
              
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Essayage::class,
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
