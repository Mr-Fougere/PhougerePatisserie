<?php

namespace App\Form;

use App\Entity\Article;
use PharIo\Manifest\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('title',TextType::class,['label'=>"Nom de la recette"])
            ->add('content',TextareaType::class,['label'=>"Recette",'attr' => array(
                'placeholder' => 'Appuyez sur Entrez pour ajouter une étape',
                'rows'=>8,"cols"=>2
            )])
            ->add('brochureFileName', FileType::class, [
                'label' => 'Photo de la recette',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Sélectionner une image',
                    ])
                ],
            ])
            ->add('time',ChoiceType::class,['label'=>"Temps",
            'choices' => [
                '5 minutes' => '5 minutes',
                '15 minutes' => '15 minutes',
                '30 minutes' => '30 minutes',
                '45 minutes' => '45 minutes',
                '1 heure' => '1 heure',
                '2 heures' => '2 heures',
                '+2 heures' => '+2 heures',
            ],
            ])
            ->add('difficulty',ChoiceType::class,['label'=>"Difficulté",
            'choices' => [
                'Facile' => 'Facile',
                'Intermédiaire' => 'Intermédiaire',
                'Expert' => 'Expert',
                'Chef' => 'Chef',
            ],
            ])
            ->add(
                'price', 
                ChoiceType::class, 
                [
                    'choices' => [
                        '€' => '€',
                        '€€' => '€€',
                        '€€€'=> '€€€'
                    ],
                'expanded' => true
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class'=>Article::class,
        ]);
        
    }
}