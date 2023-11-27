<?php

namespace App\Form;

use App\Entity\Etudient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class EtudientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('DateNaissance', DateType::class,['widget' => 'single_text'] 
            )
            ->add('Genre',ChoiceType::class,[
               'choices'=>[
                    'homme'=>'homme',
                    'femme'=>'femme', 
               ],
               'expanded' =>true,
            ])
            ->add('Etablissement', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                    
                ]
            ])
            ->add('Pere', TextType::class,[
                'attr' => [
                    'class'=>'form-control'
                ]
            ])
            ->add('Mere', TextType::class,[
                'attr' =>[
                    'class'=>'form-control'
                ]
            ])
            ->add('Region', ChoiceType::class, [
                'choices'=>[
                    'Analamanga'=>'Analamanga',
                    'Bongolava' =>'Bongolava',
                    'Vankinankaratra'=>'Vankinakaratra'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('District', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Serie',ChoiceType::class, [
                'choices'=>[
                  'A1'=>'A1',
                  'A2'=>'A2',
                  'C'=>'C',
                  'D'=>'D'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('Candidat', ChoiceType::class, [
                'choices' => [
                    'Ecole' => 'Ecole',
                    'Libre ' => 'Libre',
                ],
                'expanded' => true, // Pour afficher les boutons radio au lieu d'une liste déroulante
            ])
            ->add('Session',TextType::class ,[
                'attr' => [
                    'class' =>'form-control'
                ]
            ])
            ->add('Facultative', ChoiceType::class, [
                'choices' => [
                    'Anglais' => 'Anglais',
                    'Physique' => 'Physique'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('Individuel',ChoiceType::class,[
               'choices'=>[
                 'Vitesse'=>'Vitesse',
                 'Lance de poids'=>'Lance de poids',
                 'Saute à Hauteur'=>'Saute à hauteur',
                 'Saute à longeur'=>'Saute à longeur',
               ],
               'expanded' =>true,
            ])
            ->add('Collective', ChoiceType::class, [
                'choices'=> [
                    'Foot-ball'=>'Foot-Ball',
                    'Basket-Ball'=>'Basket-Ball',
                    'Volley-Ball'=>'Volley-Ball'
                ],
                
                'expanded' => true,
                //'required' => false,
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3 '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudient::class,
        ]);
    }
}
