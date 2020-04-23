<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categoryproduit;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProduitType extends AbstractType
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
            ->add('title',TextType::class,$this->getConfiguration("Produit","Nom du produit"))
            ->add('price',IntegerType::class,$this->getConfiguration("Prix","Tapez le montant"))
            ->add('code',TextType::class,$this->getConfiguration("Code barre","Tapez le code barre"))
            ->add('description',TextType::class,$this->getConfiguration("Description","Tapez la description"))
            ->add('image')
            ->add('qteinit',IntegerType::class,$this->getConfiguration("Quantité en stock","Quantité en stock"))
            ->add('stockplus', IntegerType::class, [
                'label' => 'Ajouter ou Enlever du Stock',
                'mapped' => false,
                
            ])
            ->add('qtemin',IntegerType::class,$this->getConfiguration("Quantité minimale","Quantité minimale"))
            ->add('categoryproduit',EntityType::class
            , [
                'class' => Categoryproduit::class,
                'choice_label' => 'title',
                'label' => 'Catégorie du produit'
                
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
