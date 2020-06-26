<?php

namespace App\Form;


use App\Entity\Amount;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AmountCreateType extends ApplicationType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount1',IntegerType::class,[ 'data' => '0'])
            ->add('paymentMethodAmount1',ChoiceType::class, [
                'choices' => [
                    ' ' => ' ',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('amount2',IntegerType::class,[ 'data' => '0'])
            ->add('paymentMethodAmount2',ChoiceType::class,[
                'choices' => [
                    ' ' => ' ',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('amount3',IntegerType::class,[ 'data' => '0'])
            ->add('paymentMethodAmount3',ChoiceType::class, [
                'choices' => [
                    ' ' => ' ',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('amount4',IntegerType::class,[ 'data' => '0'])
            ->add('paymentMethodAmount4',ChoiceType::class, [
                'choices' => [
                    ' ' => ' ',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                'label' => 'Méthode de paiement',
                ]);
            
               
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
        ]);
    }
}
