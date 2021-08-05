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
                ],
                'attr' => [
                    'class' => 'fr-select',
                ],
                'label' => 'Mon besoin',
                'label_attr' => [
                    'class' => 'fr-label h3 on-dark fr-mb-3w',
                ],
                'required' => true,
            ])
            ->add('region', ChoiceType::class, [
                'choices' => $options['regions'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'placeholder' => 'Toute la France',
                'label' => 'Ma région',
                'attr' => [
                    'class' => 'fr-select',
                ],
                'label_attr' => [
                    'class' => 'fr-label h3 on-dark fr-mb-3w',
                ],
            ])
            ->add('environmentalTopic', ChoiceType::class, [
                'choices' => $options['environmentalTopics'],
                'choice_value' => 'name',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'fr-select',
                ],
                'placeholder' => 'Choisir une thématique',
                'label' => 'Ma thématique',
                'label_attr' => [
                    'class' => 'fr-label h3 on-dark fr-mb-3w',
                ],
            ])
            ->add('regionalLimit', HiddenType::class, [
                'empty_data' => 6,
            ])
            ->add('nationalLimit', HiddenType::class, [
                'empty_data' => 6,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'environmentalTopics' => [],
            'businessActivityAreas' => [],
            'regions' => [],
            'csrf_protection' => false,
        ]);

        $resolver
            ->setAllowedTypes('environmentalTopics', 'array')
            ->setAllowedTypes('businessActivityAreas', 'array')
            ->setAllowedTypes('regions', 'array')
        ;
    }
}
