<?php

namespace App\Form;

use App\Entity\Amount;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AmountType extends ApplicationType
{

     

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      

        $builder
            ->add('amount1',IntegerType::class,$this->getConfiguration("Montant 1"," "))
            ->add('numcheque',TextType::class,$this->getConfiguration("numero cheque"," "))
            ->add('name',TextType::class,$this->getConfiguration("name"," "))
            ->add('paymentMethodAmount1',ChoiceType::class, [
                'choices' => [
                    ' '                => ' ',
                    'CB'               => 'CB',
                    'Cheque'           => 'Chèque',
                    'Espece'           => 'Espèce',
                    'Carte Collégiens' => 'Carte Collégiens',
                    'Carte lycéens'    => 'Carte lycéens',
                    'ANCV'             => 'ANCV'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('amount2',IntegerType::class,$this->getConfiguration("Montant 2"," "))
            ->add('numcheque2',TextType::class,$this->getConfiguration("numero cheque"," "))
            ->add('name2',TextType::class,$this->getConfiguration("name"," "))
            ->add('paymentMethodAmount2',ChoiceType::class, [
                'choices' => [
                    ' '                => ' ',
                    'CB'               => 'CB',
                    'Cheque'           => 'Chèque',
                    'Espece'           => 'Espèce',
                    'Carte Collégiens' => 'Carte Collégiens',
                    'Carte lycéens'    => 'Carte lycéens',
                    'ANCV'             => 'ANCV'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('amount3',IntegerType::class,$this->getConfiguration("Montant 3"," "))
            ->add('numcheque3',TextType::class,$this->getConfiguration("numero cheque"," "))
            ->add('name3',TextType::class,$this->getConfiguration("name"," "))
            ->add('paymentMethodAmount3',ChoiceType::class, [
                'choices' => [
                    ' '                => ' ',
                    'CB'               => 'CB',
                    'Cheque'           => 'Chèque',
                    'Espece'           => 'Espèce',
                    'Carte Collégiens' => 'Carte Collégiens',
                    'Carte lycéens'    => 'Carte lycéens',
                    'ANCV'             => 'ANCV'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('amount4',IntegerType::class,$this->getConfiguration("Montant 4"," "))
            ->add('numcheque4',TextType::class,$this->getConfiguration("numero cheque"," "))
            ->add('name4',TextType::class,$this->getConfiguration("name"," "))
            ->add('paymentMethodAmount4',ChoiceType::class, [
                'choices' => [
                    ' '                => ' ',
                    'CB'               => 'CB',
                    'Cheque'           => 'Chèque',
                    'Espece'           => 'Espèce',
                    'Carte Collégiens' => 'Carte Collégiens',
                    'Carte lycéens'    => 'Carte lycéens',
                    'ANCV'             => 'ANCV'
                ],
                'label' => 'Méthode de paiement',
                ])
           
           
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Amount::class,
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
     
    }
}
