<?php

namespace App\Form;

use App\Entity\Adherent;
use App\form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class AdherentType extends ApplicationType

{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName',TextType::class,$this->getConfiguration("Nom","Tapez le nom de famille"))
            ->add('firstName',TextType::class,$this->getConfiguration("Prénom","Tapez le prénom "))
            ->add('born', BirthdayType::class,$this->getConfiguration("Né(e) le","Tapez la date de naissance "),[
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'dd-MM-yyyy',
                
            ])
            
            ->add('subCategory',TextType::class,$this->getConfiguration("Sous-catégorie","Tapez la catégorie "))
            ->add('toNumber',IntegerType::class,$this->getConfiguration("Numéro adhérent","Tapez le numéro d'adhérent"))
            ->add('sex', ChoiceType::class, [
                'choices' => [
                    'M' => 'M',
                    'F' => 'F',
                ],
                ])
            ->add('complement',TextType::class,$this->getConfiguration("complément d'adresse","Tapez le complément d'adresse "))
            ->add('address',TextType::class,$this->getConfiguration("Adresse","Tapez l'adresse"))
            ->add('lieut',TextType::class,$this->getConfiguration("Lieu","Tapez le lieut"))
            ->add('postalCode',IntegerType::class,$this->getConfiguration("Code Postal","Tapez le code postal"))
            ->add('city',TextType::class,$this->getConfiguration("Ville","Tapez la ville de naissance"))
            //->add('record',DateTimeType::class,$this->getConfiguration("Date d'enregistrement","Tapez la date d'enregistrement"))
            ->add('licenceType',TextType::class,$this->getConfiguration("Type de licence","Tapez le type de licence"))
            ->add('homePhone',TextType::class,$this->getConfiguration("Téléphone maison","Tapez le téléphone du domicile"))
            ->add('mobilePhone',TextType::class,$this->getConfiguration("Téléphone mobile","Tapez le téléphone mobile"))
            ->add('fax',TextType::class,$this->getConfiguration("Fax","Tapez le numéro de fax"))
            ->add('email',EmailType::class,$this->getConfiguration("Email","Tapez votre email"))
            ->add('categoryArbitre',TextType::class,$this->getConfiguration("Catégorie d'arbitre","Tapez la catégorie d'arbitre"))
            ->add('placeOfBirth',TextType::class,$this->getConfiguration("Lieu de naissance","Tapez le lieu de naissance"))
            ->add('clubChange',TextType::class,$this->getConfiguration("Changement de club","Tapez le changement de club"))
            ->add('clubOut',TextType::class,$this->getConfiguration("Club quitté","Tapez le club quitté"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherent::class,
        ]);
    }
}
