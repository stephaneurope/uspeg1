<?php

namespace App\Form;

use App\Entity\CategoryAdherent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CategoryAdherentType extends AbstractType
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
            ->add('title',TextType::class,$this->getConfiguration("Catégorie","Tapez la nouvelle catégorie d'adhérent"))
            ->add('montantcot',IntegerType::class,$this->getConfiguration("Montant de la cotisation","Tapez le montant de la cotisation"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoryAdherent::class,
        ]);
    }
}
