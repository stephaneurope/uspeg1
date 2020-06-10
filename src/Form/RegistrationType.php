<?php

namespace App\Form;


use App\Entity\Role;
use App\Entity\User;
use App\form\ApplicationType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre prénom ..."))
            ->add('lastName',TextType::class, $this->getConfiguration("Nom", "Votre nom ..."))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email ..."))
            //->add('picture',UrlType::class, $this->getConfiguration("Photo de profil", "Url de votre avatar ..."))
            ->add('hash',PasswordType::class, $this->getConfiguration("Mot de passe", "Choisissez votre mot de passe ..."))
            ->add('passwordConfirm',PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "Veuillez confirmer votre mot de passe !"))
            ->add('add', ChoiceType::class, array(
                'label' => 'Role',
                
                'choices' => [
                    'utilisateur'=> 0,
                    'Administrateur' => 1
                ],
                 'mapped' => false, // Form works when false, but doesn't save/create UserRole entry
            ))
            //->add('description',TextType::class, $this->getConfiguration("Description", "Description ..."))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
