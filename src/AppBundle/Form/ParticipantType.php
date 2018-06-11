<?php
namespace AppBundle\Form;

use AppBundle\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('age')
            ->add('gender', ChoiceType::class, [
                'placeholder' => 'Choisir dans la liste',
                'choices' => [
                    'Masculin'=>'M',
                    'Féminin'=>'F',
                ]
            ])
            ->add('specialty', ChoiceType::class, [
                'placeholder' => 'Choisir dans la liste',
                'choices'=>[
                    'Médecin généraliste avec pratique uniquement ambulatoire'=>'mga',
                    'Médecin généraliste avec pratique uniquement hospitalière'=>'mgh',
                    'Médecin généraliste avec pratique mixte (ambulatoire et hospitalière)'=>'mgm',
                    'Cardiologue avec pratique uniquement ambulatoire'=>'cardioa',
                    'Cardiologue avec pratique uniquement hospitalière'=>'cardioh',
                    'Cardiologue avec pratique mixte (ambulatoire et hospitalière)'=>'cardiom',
                    'Autres'=>'autres',
                ]
            ])
            ->add('thesisDate')
            ->add('cumulPercent', ChoiceType::class, [
                'placeholder' => 'Choisir dans la liste',
                'choices'=>[
                    '< 5%'=>'< 5%',
                    '5% - 10%'=>'5% - 10%',
                    '11% - 20%'=>'11% - 20%',
                    '> 20%'=>'> 20%',
                ]
            ])
            ->add('atEase', ChoiceType::class, [
                'placeholder' => 'Choisir dans la liste',
                'choices'=>[
                    'très à l\'aise'=>'très à l\'aise',
                    'plutôt à l\'aise'=>'plutôt à l\'aise',
                    'plutôt pas à l\'aise'=>'plutôt pas à l\'aise',
                    'pas à l\'aise du tout'=>'pas à l\'aise du tout',
                ]
            ])
            ->add('whereToReco', ChoiceType::class, [
                'placeholder' => 'Choisir dans la liste',
                'choices'=>[
                    'oui'=>'oui',
                    'non'=>'non',
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Participant::class,
        ));
    }
}