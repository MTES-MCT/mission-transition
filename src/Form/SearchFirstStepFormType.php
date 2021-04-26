<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                    'des actions premier pas' => 'first-steps',
                ],
                'label' => 'Mon besoin',
                'attr' => [
                    'class' => 'rf-select',
                ],
            ])
            ->add('environmentalAction', HiddenType::class)
        ;
    }

    public function getBlockPrefix()
    {
        return 'search_form';
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
