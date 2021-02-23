<?php

namespace App\Form;

use App\Entity\Pack;
use App\Form\ApplicationType;
use App\Entity\CategoryAdherent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CategoryAdherentType extends ApplicationType
{

   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,$this->getConfiguration("Catégorie","Tapez la nouvelle catégorie d'adhérent"))
            ->add('montantcot',IntegerType::class,$this->getConfiguration("Montant de la cotisation","Tapez le montant de la cotisation"))
            ->add('list',IntegerType::class,$this->getConfiguration("Ordre dans la liste des catégories","Tapez le nombre pour définir l'ordre de la catégorie"))
            ->add('pack',EntityType::class,
            [
                'class' => Pack::class,
                'choice_label' => 'name'
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoryAdherent::class,
        ]);
    }
}
