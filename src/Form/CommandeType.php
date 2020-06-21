<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CommandeType extends ApplicationType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            //->add('datecommande', DateType::class, $this->getConfiguration("Date de la commande", "Inserez la date de la commande"))
            ->add('qte', IntegerType::class, $this->getConfiguration("Quantité stock", "Tapez la quantité du stock"))
            ->add(
                'produit',
                EntityType::class,
                [
                    'class' => Produit::class,
                    'choice_label' => 'code',
                    
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
