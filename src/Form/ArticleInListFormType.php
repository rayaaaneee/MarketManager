<?php

namespace App\Form;

use App\Entity\ArticleInList;
use Doctrine\ORM\Query\Expr\Select;
use FFI;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use DateTime;

class ArticleInListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $shoppingLists = $options['shopping_lists'];
        $tabChoices = [];
        foreach ($shoppingLists as $shoppingList) {
            if ($shoppingList->hasEndDate()) {
                $endDate = DateTime::createFromInterface($shoppingList->getEndDate())->setTime(0, 0, 0);
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                $now = $now->setTime(0, 0, 0);
                if ($endDate >= $now) {
                    $tabChoices[$shoppingList->getName()] = $shoppingList->getId();
                }
            } else {
                $tabChoices[$shoppingList->getName()] = $shoppingList->getId();
            }
        }
        $builder
            ->setAttributes([
                'class' => 'form-inline'
            ])
            ->add(
                'quantity',
                IntegerType::class,
                [
                    'label' => 'Quantity',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Quantity'
                    ]
                ]
            )
            ->add(
                'unityPrice',
                NumberType::class,
                [
                    'label' => 'Unity price ( € )',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Unity price',
                    ]
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Name',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Name'
                    ]
                ]
            )
            ->add(
                'brand',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Brand',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Unknown'
                    ]
                ]
            )
            ->add(
                'shoppingList',
                ChoiceType::class,
                [
                    'label' => 'Please select a shopping list',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => $tabChoices,
                    'placeholder' => 'Select your shopping list',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Add this article to my list',
                    'attr' => [
                        'class' => 'btn btn-primary',
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleInList::class,
            'shopping_lists' => []
        ]);

        $resolver->setAllowedTypes('shopping_lists', 'array');
    }
}
