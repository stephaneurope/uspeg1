<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommandeclientType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('datecommande', DateType::class, $this->getConfiguration("Date de la commande", "Inserez la date de la commande"))
            ->add('qte', IntegerType::class, $this->getConfiguration("Quantité à distribuer", "Tapez la quantité à distribuer"), array('required'  => true)
            )
            ->add(
                'produit',
                EntityType::class,
                [
                    'class' => Produit::class,
                    'choice_label' => 'code',
                    
                ]
            )
            ->add('payment',ChoiceType::class,[
                'choices' => [
                    ' ' => ' ',
                    'CB' => 'CB',
                    'Cheque' => 'Chèque',
                    'Espece' => 'Espèce',
                    'Chequier Jeunes' => 'Chequier Jeunes'
                ],
                'label' => 'Méthode de paiement',
                ])
            ->add('comment', TextareaType::class, $this->getConfiguration("Commentaire", "Tapez votre commentaire"))
            
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'attr' => [
                'novalidate' => 'novalidate', // comment me to reactivate the html5 validation!  🚥
            ]
        ]);
    }
}
