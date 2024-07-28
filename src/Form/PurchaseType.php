<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('currency', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('card_number', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 13, 'max' => 19]),
                ],
            ])
            ->add('card_exp_month', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('card_exp_year', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('card_cvv', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 4]),
                ],
            ]);
    }

    final public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
