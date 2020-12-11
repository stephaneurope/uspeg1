<?php

namespace App\Form;


use App\Entity\Team;
use App\Entity\Adherent;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ConvocationType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $mails= $options['mails'];
       
   //var_dump($mails);exit();

        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre',
            'disabled' => true,
            'data' => 'Convocation',
            'attr' =>  [
                'class'=> 'form-control'
            ]
        ])
       
        ->add('emailTo', ChoiceType::class, [
            'choices'  => $mails,
            'multiple' => true,
            'expanded'=>true,
            'mapped'=>true,
            'label'=> 'Emails sélectionnées',
            'choice_attr' => function() {
                return ['checked' => 'checked'];
            },
            ])
        
       /* ->add('emailTo',EntityType::class, [
            'label' => 'Emails sélectionnés',
            // Multiple selection allowed
            'multiple' => true,
            // Render as checkboxes
            'expanded' => true,
            // This field shows all the categories
            'class'  => Adherent::class,
            'choice_label' => 'LNAndFn',
            'mapped' => false,
            'choice_attr' => function() {
                return ['checked' => 'checked'];
            },
        
            
            ])*/
       /* ->add('email', EmailType::class,[
            'label' => 'Votre e-mail',
            'attr' => [
                'class' => 'form-control'
            ]
        ])*/
        ->add('convocation_date', DateType::class,[
            'label' => 'Date de la convocation',
            'html5'  => false,
            'format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                
            ]
           
        ])
        ->add('club_adverse',TextType::class,[
            'label' => 'Club adverse'
        ])
        ->add('rendez_vous_date', DateTimeType::class,[
            'label' => 'date du rendez-vous',
            'date_format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                'hour' => 'Heures', 'minute' => 'Minute', 'second' => 'Seconde',
            ]
            
        ])
        ->add('lieu',TextType::class,[
            'label' => 'lieu de rendez-vous'
        ])
        ->add('match_date',DateTimeType::class,[
            'label' => 'Date et heure du match',
            'date_format' => 'dd-MM-yyyy',
            'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                'hour' => 'Heures', 'minute' => 'Minute', 'second' => 'Seconde',
            ]
        ])
        ->add('stade',TextType::class,[
            'label' => 'Nom du stade'
        ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'mails' => null,
        ]);

 
    }


    
}
