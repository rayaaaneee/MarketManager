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
        ->add('Surname', null, [
            'label' => 'Nom de famille:',
            'required' => true,
        ])
        ->add('Password', PasswordType::class, [
            'label' => 'Mot de passe',
            'attr' => ['class' => 'password-field'],
            'required' => true,
            'invalid_message' => 'Le mot de passe est invalide.',
        ])        
    ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
