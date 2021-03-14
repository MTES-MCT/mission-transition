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
            'environmentalActions' => []
        ]);

        $resolver->setAllowedTypes('environmentalActions', 'array');
    }
}
