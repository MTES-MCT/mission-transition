<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aidType', ChoiceType::class, [
                'choices' => [
                    'Trouver un financement' => 'funding',
                    'Trouver des actions premier pas' => 'first-steps',
                ],
                'attr' => [
                    'class' => 'rf-select',
                ],
                'label' => 'Mon besoin',
                'label_attr' => [
                    'class' => 'rf-label h3 on-dark rf-mb-3w',
                ],
            ])
            ->add('region', ChoiceType::class, [
                'choices' => $options['regions'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'placeholder' => 'Toute la France',
                'label' => 'Ma région',
                'attr' => [
                    'class' => 'rf-select',
                ],
                'label_attr' => [
                    'class' => 'rf-label h3 on-dark rf-mb-3w',
                ],
            ])
            ->add('environmentalAction', ChoiceType::class, [
                'choices' => $options['environmentalActions'],
                'choice_value' => 'name',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'rf-select',
                ],
                'label' => 'Mon objectif',
                'label_attr' => [
                    'class' => 'rf-label h3 on-dark rf-mb-3w',
                ],
            ])
            ->add('regionalLimit', HiddenType::class, [
                'empty_data' => 3,
            ])
            ->add('nationalLimit', HiddenType::class, [
                'empty_data' => 3,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'environmentalActions' => [],
            'businessActivityAreas' => [],
            'regions' => [],
            'csrf_protection' => false,
        ]);

        $resolver
            ->setAllowedTypes('environmentalActions', 'array')
            ->setAllowedTypes('businessActivityAreas', 'array')
            ->setAllowedTypes('regions', 'array')
        ;
    }
}
