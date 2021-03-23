<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('companyName', FormType::class, [
//                'mapped' => false,
//                'attr' => [
//                    'data-controller' => 'search'
//                ]
//            ])
            ->add('aidType', ChoiceType::class, [
                'choices' => [
                    'un financement' => 'funding',
                    'des actions faciles' => 'first-steps',
                ],
                'label' => 'Mon besoin',
            ])
            ->add('region', ChoiceType::class, [
                'choices' => $options['regions'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'placeholder' => 'Toute la France',
                'label' => 'Ma région',
            ])
//            ->add('businessActivityAreas', ChoiceType::class, [
//                'choices' => $options['businessActivityAreas'],
//                'choice_value' => 'id',
//                'choice_label' => 'name',
//                'multiple' => true
//            ])
            ->add('environmentalAction', ChoiceType::class, [
                'choices' => $options['environmentalActions'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'label' => 'Vos objectifs de transition écologique',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'environmentalActions' => [],
            'businessActivityAreas' => [],
            'regions' => [],
        ]);

        $resolver
            ->setAllowedTypes('environmentalActions', 'array')
            ->setAllowedTypes('businessActivityAreas', 'array')
            ->setAllowedTypes('regions', 'array')
        ;
    }
}
