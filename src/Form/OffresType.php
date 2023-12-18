<?php

namespace App\Form;

use App\Entity\Offres;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('titre')
            ->add('nombre')
            ->add('description', TextareaType::class ,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ] )
            /*->add('date')*/
            ->add('date'
                , DateTimeType
                ::class, ['widget' => 'single_text','html5' => false,'attr' => ['class' => 'datepicker'],])
            ->add('qualification')
            ->add('experience')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
