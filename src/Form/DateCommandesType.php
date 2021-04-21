<?php

namespace App\Form;

use App\Entity\DateCommandes;
use App\Form\ApplicationType;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DateCommandesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom', DateType::class,
            [
                'label' => 'Date du debut de la plage du calendrier',
                'format' => 'dd-MM-yyyy',
            ]
            )
            ->add('dateTo', DateType::class,
            [
                'label' => 'Date de fin de la plage du calendrier',
                'format' => 'dd-MM-yyyy',
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DateCommandes::class,
        ]);
    }
}
