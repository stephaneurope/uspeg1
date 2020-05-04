<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Adherent;
use App\Entity\Commande;
use App\Repository\AdherentRepository;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CommandeType extends AbstractType
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
            ->add('datecommande',DateType::class,$this->getConfiguration("Date de la commande","Inserez la date de la commande"))
            ->add('qte',IntegerType::class,$this->getConfiguration("Quantité stock","Tapez la quantité du stock"))
            ->add('produit',EntityType::class
            , [
                'class' => Produit::class,
                'choice_label' => 'title'
                
                ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
