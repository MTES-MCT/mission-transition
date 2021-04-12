<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchSecondStepFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', FormType::class, [
                'mapped' => false,
                'attr' => [
                    'data-controller' => 'search',
                ],
            ])
            ->add('aidType', HiddenType::class)
            ->add('environmentalAction', HiddenType::class, [
            ])
            ->add('region', ChoiceType::class, [
                'choices' => $options['regions'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'placeholder' => 'Toute la France',
                'label' => 'Ma région',
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'search_form';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'regions' => [],
            'csrf_protection' => false,
        ]);

        $resolver
            ->setAllowedTypes('regions', 'array')
        ;
    }
}
