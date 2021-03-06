<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToolReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prescription', ChoiceType::class, [
                'label' => 'L\'outil d\'aide à la prescription m’a aidé pour la prescription d’antithrombotiques pour les vignettes',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('changes', ChoiceType::class, [
            	'label' => 'L\'outil d\'aide à la prescription a modifié les réponses que j’aurais spontanément fait aux vignettes',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('clear', ChoiceType::class, [
            	'label' => 'L\'outil d\'aide à la prescription proposé est clair',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('operational', ChoiceType::class, [
            	'label' => 'L\'outil d\'aide à la prescription proposé est facile à utiliser',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('useful', ChoiceType::class, [
            	'label' => 'L\'outil d\'aide à la prescription proposé est utile pour la pratique',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('ready', ChoiceType::class, [
            	'label' => 'Je serais prêt à utiliser cet outil',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('recommend', ChoiceType::class, [
            	'label' => 'Je recommanderais l’utilisation de cet outil',
                'label_attr' => [
                	'class' => 'radio-inline',
                ],
                'expanded' => true,
                'placeholder' => 'Choisir dans la liste',
                'choices'=>range(0,10),
            ])
            ->add('remarks', TextareaType::class, [
            	'label' => 'Nous sommes en train de développer une version numérique accessible en ligne pour tous. Quels sont les points de l\'outil d\'aide à la prescription qui pourraient être améliorés : informations inutiles, informations manquantes, suggestions de présentation différentes, etc:',
            	'required' => false,
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        // $resolver->setDefaults(array(
        //     'data_class' => Participant::class,
        // ));
    }
}
