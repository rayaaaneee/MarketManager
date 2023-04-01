<?php

namespace App\Form;

use App\Entity\ArticleInList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModifyArticleInListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $commonClasses = 'inputs-modify-article-in-list switched';
        $builder
            ->add(
                'id',
                HiddenType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'minlength' => 1,
                        'readonly' => true,
                        'hidden' => true,
                        'value' => $options['id']
                    ]
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => $commonClasses,
                        'placeholder' => 'Name',
                        'minlength' => 3
                    ]
                ]
            )
            ->add(
                'quantity',
                IntegerType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => $commonClasses,
                        'placeholder' => 'Quantity',
                        'min' => 1
                    ]
                ]
            )
            ->add(
                'unityPrice',
                NumberType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => $commonClasses,
                        'placeholder' => 'Unity price',
                        'min' => 0.01
                    ]
                ]
            )
            ->add(
                'brand',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'class' => $commonClasses,
                        'placeholder' => 'Brand',
                        'minlength' => 1
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => false,
                    'attr' => [
                        'class' => 'btn btn-primary btn-submit-validate-modify-article-in-list inputs-modify-article-in-list switched',
                        "title" => "Validate modifications"
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleInList::class,
            'id' => null
        ]);
        $resolver->setAllowedTypes('id', 'int');
    }
}
