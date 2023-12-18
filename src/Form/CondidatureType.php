<?php

namespace App\Form;

use App\Entity\Condidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CondidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             /*->add('date')*/
             ->add('CV', FileType::class, [
                 'label' => 'CV (PDF file)',

                 // unmapped means that this field is not associated to any entity property
                 'mapped' => false,

                 // make it optional so you don't have to re-upload the PDF file
                 // every time you edit the Product details
                 'required' => false,
             ])



            ->add('LM', TextareaType::class ,[
                "attr" =>[
                    "class"=>"form-control"
                ]
            ] )
            ->add('nom')
            ->add('prenom')
            ->add('email' , EmailType::class)
            ->add('tel' , IntegerType::class)
            /*->add('Offres')
            ->add('User')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Condidature::class,
        ]);
    }
}
