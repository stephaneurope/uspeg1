<?php

namespace App\Form;


use App\Entity\Amount;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AmountCreateType extends ApplicationType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount1',IntegerType::class,$this->getConfiguration("Montant 1","Tapez le montant"))
            ->add('paymentMethodAmount1',ChoiceType::class, [
                'choices' => [
                    'Néant' => 'Néant',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('amount2',IntegerType::class,$this->getConfiguration("Montant 2","Tapez le montant"))
            ->add('paymentMethodAmount2',ChoiceType::class, [
                'choices' => [
                    'Néant' => 'Néant',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('amount3',IntegerType::class,$this->getConfiguration("Montant 3","Tapez le montant"))
            ->add('paymentMethodAmount3',ChoiceType::class, [
                'choices' => [
                    'Néant' => 'Néant',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('amount4',IntegerType::class,$this->getConfiguration("Montant 4","Tapez le montant"))
            ->add('paymentMethodAmount4',ChoiceType::class, [
                'choices' => [
                    'Néant' => 'Néant',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
        ]);
    }
}
