<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', null, [
                'label' => 'Prénom:',
            ])
            ->add('Surname', null, [
                'label' => 'Nom de famille:',
            ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                //le mot de passe doit être plus grand que 6 caractères et doit avoir au moins une lettre et un chiffre
                'first_options' => ['label' => 'Mot de passe', 'attr' => ['pattern' => '^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,}$']],
                'second_options' => ['label' => 'Répéter le mot de passe'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
