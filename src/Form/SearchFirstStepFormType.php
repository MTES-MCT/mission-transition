<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFirstStepFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aidType', ChoiceType::class, [
                'choices' => [
                    'un financement' => 'funding',
                    'des actions faciles' => 'first-steps',
                ],
                'label' => 'Mon besoin',
            ])
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
            'csrf_protection' => false,
        ]);

        $resolver
            ->setAllowedTypes('environmentalActions', 'array')
        ;
    }
}
