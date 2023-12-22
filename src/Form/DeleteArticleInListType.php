<?php

namespace App\Form;

use App\Entity\ArticleInList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteArticleInListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('totalPrice')
            ->add('unityPrice')
            ->add('name')
            ->add('brand')
            ->add('shoppingList')
            ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleInList::class,
        ]);
    }
}
