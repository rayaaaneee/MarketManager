<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $types = $options['types'];
        $action = $options['action'];
        $tabChoices = [];
        foreach ($types as $type) {
            $tabChoices[$type->getName()] = $type->getId();
        }

        $builder
            ->setMethod('GET')
            ->setAction($action)
            ->add(
                'search',
                TextType::class,
                [
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Search an article on Market Manager ..',
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'type',
                ChoiceType::class,
                [
                    'required' => false,
                    'placeholder' => 'Select a type',
                    'choices' => $tabChoices,
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Search',
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'types' => [],
            'action' => './'
        ]);
        $resolver->setAllowedTypes('types', 'array', 'string');
    }
}
