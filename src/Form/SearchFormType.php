<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', FormType::class, [
                'mapped' => false,
                'attr' => [
                    'data-controller' => 'search'
                ]
            ])
            ->add('regionName', TextType::class)
            ->add('businessActivityAreas', ChoiceType::class, [
                'choices' => $options['businessActivityAreas'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('environmentalActions', ChoiceType::class, [
                'choices' => $options['environmentalActions'],
                'choice_value' => 'id',
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'environmentalActions' => [],
            'businessActivityAreas' => []
        ]);

        $resolver
            ->setAllowedTypes('environmentalActions', 'array')
            ->setAllowedTypes('businessActivityAreas', 'array');
    }
}
