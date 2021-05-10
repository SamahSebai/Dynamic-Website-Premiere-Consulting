<?php

namespace App\Form;

use App\Entity\Services;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('description', TextareaType::class ,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('etat', TextType::class,[
                    "attr" =>[
                        "class"=>"form-control"
                    ]
                ]
            )
            ->add('prix', TextType::class,[
                    "attr" =>[
                        "class"=>"form-control"
                    ]
                ]
            )
            ->add('referance', TextType::class,[
                    "attr" =>[
                        "class"=>"form-control"
                    ]
                ]
            )
            ->add('date'
                ,DateTimeType
                ::class, ['widget' => 'single_text','html5' => false,'attr' => ['class' => 'datepicker'],])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
