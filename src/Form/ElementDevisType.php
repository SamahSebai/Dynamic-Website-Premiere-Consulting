<?php

namespace App\Form;

use App\Entity\ElementDevis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementDevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prixUnitaire')
            ->add('Tax')
            ->add('Quantite')
            ->add('reduction')
            ->add('PTTC')
            ->add('Devis')
            ->add('Services')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ElementDevis::class,
        ]);
    }
}
