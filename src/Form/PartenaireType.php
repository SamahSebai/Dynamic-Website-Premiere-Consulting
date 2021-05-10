<?php

namespace App\Form;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('adress', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('localisation', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('telephone')
            ->add('email')
            ->add('responsable', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('type', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('description', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('secteur_activite', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('media', FileType::class, [
                'label' => 'Images',
                'mapped'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
