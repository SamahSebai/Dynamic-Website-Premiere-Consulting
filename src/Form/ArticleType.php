<?php

namespace App\Form;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre' , TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('auteur', TextType::class,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ] )
            ->add('introduction', TextareaType::class ,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ])
            ->add('date_ajout'
                ,DateTimeType
                ::class, ['widget' => 'single_text','html5' => false,'attr' => ['class' => 'datepicker'],])
            ->add('contenu' , CKEditorType::class ,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ] )
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped'=>false,
                'required'=>false
            ])


        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
