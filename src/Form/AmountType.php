<?php

namespace App\Form;

use App\Entity\Amount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AmountType extends AbstractType
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
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
        ]);
    }
}
