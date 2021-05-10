<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule_mission' , TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('nb_de_jour' , TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('date_debut'
                ,DateTimeType
                ::class, ['widget' => 'single_text','html5' => false,'attr' => ['class' => 'datepicker'],])

            ->add('date_fin'
                ,DateTimeType
                ::class, ['widget' => 'single_text','html5' => false,'attr' => ['class' => 'datepicker'],])

            ->add('localisation_mission' , TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('cout_provisoire' , TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('description' , TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('User')

            ->add('media', FileType::class, [
                'label' => 'Images',
                'mapped'=>false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
