<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserConnectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAttributes(['class' => 'form-signin'])
            ->add('Name', null, [
                'label' => 'Name',
                'attr' => ['class' => 'form-control', 'id' => 'floatingName', 'placeholder' => 'Your name'],
                'required' => true,
            ])
            ->add('Surname', null, [
                'label' => 'Surname',
                'attr' => ['class' => 'form-control', 'id' => 'floatingSurname', 'placeholder' => 'Your surname'],
                'required' => true,
            ])
            ->add('Password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['class' => 'form-control', 'id' => 'floatingPassword', 'placeholder' => 'Your password'],
                'required' => true,
                'invalid_message' => 'Le mot de passe est invalide.',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
