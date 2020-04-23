<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Entity\Amount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AmountCreateType extends AbstractType
{
    

    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label,$placeholder) {
        return [
            'label' =>$label,
            'attr'  => [
                'placeholder' => $placeholder
            ]
            ];
}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount1',IntegerType::class,$this->getConfiguration("Montant 1","Tapez le montant"))
            ->add('paymentMethodAmount1',ChoiceType::class, [
                'choices' => [
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('amount2',IntegerType::class,$this->getConfiguration("Montant 2","Tapez le montant"))
            ->add('paymentMethodAmount2',ChoiceType::class, [
                'choices' => [
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('amount3',IntegerType::class,$this->getConfiguration("Montant 3","Tapez le montant"))
            ->add('paymentMethodAmount3',ChoiceType::class, [
                'choices' => [
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('amount4',IntegerType::class,$this->getConfiguration("Montant 4","Tapez le montant"))
            ->add('paymentMethodAmount4',ChoiceType::class, [
                'choices' => [
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                ])
            ->add('adherent',EntityType::class
            , [
                'class' => Adherent::class,
                'choice_label' => function() {
                    
                  return ('lastName');}
                
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
        ]);
    }
}
