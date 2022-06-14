<?php

namespace App\Form;

use App\Entity\Aide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AidStateFilterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'Publiée' => 'published',
                'Brouillon' => 'draft',
            ],
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
