<?php

namespace App\Form;

use App\Entity\Categoryproduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryProduitType extends AbstractType
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
            ->add('title',TextType::class,$this->getConfiguration("Catégorie","Tapez la catégorie"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categoryproduit::class,
        ]);
    }
}
