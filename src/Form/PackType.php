<?php

namespace App\Form;

use App\Entity\Pack;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PackType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('name', TextType::class,$this->getConfiguration("Nom du Pack","Tapez le nom du pack"))
            ->add('option1', TextType::class,$this->getConfiguration("Equipement 1","Tapez le nom de l'equipement"))
            ->add('option2', TextType::class,$this->getConfiguration("Equipement 2","Tapez le nom de l'equipement"))
            ->add('option3', TextType::class,$this->getConfiguration("Equipement 3","Tapez le nom de l'equipement"))
            ->add('option4', TextType::class,$this->getConfiguration("Equipement 4","Tapez le nom de l'equipement"))
            ->add('option5', TextType::class,$this->getConfiguration("Equipement 5","Tapez le nom de l'equipement"))
            ->add('option6', TextType::class,$this->getConfiguration("Equipement 6","Tapez le nom de l'equipement"))
            ->add('option7', TextType::class,$this->getConfiguration("Equipement 7","Tapez le nom de l'equipement"))
            ->add('option8', TextType::class,$this->getConfiguration("Equipement 8","Tapez le nom de l'equipement"))
            ->add('option9', TextType::class,$this->getConfiguration("Equipement 9","Tapez le nom de l'equipement"))
            ->add('option10', TextType::class,$this->getConfiguration("Equipement 10","Tapez le nom de l'equipement"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pack::class,
        ]);
    }
}
