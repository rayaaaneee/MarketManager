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
            ->setAttributes(['class' => 'form-signup'])
            ->add('Name', null, [
                'label' => 'First name',
                'attr' => ['class' => 'form-control', 'id' => 'floatingName', 'placeholder' => 'Your first name']
            ])
            ->add('Surname', null, [
                'label' => 'Surname',
                'attr' => ['class' => 'form-control', 'id' => 'floatingSurname', 'placeholder' => 'Your surname']
            ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Passwords must match.',
                'options' => ['attr' => ['placeholder' => 'Your password']],
                'required' => true,
                //le mot de passe doit être plus grand que 6 caractères et doit avoir au moins une lettre et un chiffre
                'first_options' => ['label' => 'Password', 'attr' => ['class' => 'form-control', 'id' => 'floatingPassword', 'placeholder' => 'Your password', 'pattern' => '^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,}$']],
                'second_options' => ['label' => 'Repeat password', 'attr' => ['class' => 'form-control', 'id' => 'floatingRepeatPassword', 'placeholder' => 'Repeat your password']]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
