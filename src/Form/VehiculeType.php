<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'SAISIR UN TITRE !!!!']),
                    new Length([
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => '5 min',
                        'maxMessage' => '100 max'
                    ])
                ]
            ])
            ->add('marque', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Saisire une marque !!!!']),
                    new Length([
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => '5 min',
                        'maxMessage' => '100 max'
                    ])
                ]
            ])
            ->add('modele', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Saisire un modele !!!!']),
                    new Length([
                        'min' => 2,
                        'max' => 10,
                        'minMessage' => '2 min',
                        'maxMessage' => '10 max'
                    ])
                ]
            ])

            ->add('description', TextareaType::class)

            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'onchange' => "loadFile(event)" 
                ]
                ])
            ->add('prix', MoneyType::class, [
                'currency' => 'EUR',
                'required' => false,
                'help' => 'Prix journalier',
                'label' => 'Prix*'
            ])

            // ->add('enregisterAt', DateTimeType::class, [
            //     'widget' => 'choice',
            // ])

            // ->add('commande', EntityType::class, [
            //     'class' => Commande::class,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
