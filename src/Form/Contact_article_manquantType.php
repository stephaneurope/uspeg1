<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class Contact_article_manquantType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
       
  

        $builder
       // ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
           
        ]);

 
    }


    
}
