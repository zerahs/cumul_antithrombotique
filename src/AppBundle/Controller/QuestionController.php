<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Participant;
use AppBundle\Model\Vignette;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/question")
 */
class QuestionController extends Controller
{

    private $questionData = [
        'id'   => 1,
        'text' => 'Quelle est la couleur du cheval blanc d\'Henry IV ?',
        'answers' => [
            'blanc' => 'blanc',
            'noir' => 'noir',
            'rouge' => 'rouge',
            'jaune' => 'jaune',
        ],
    ];

    /**
     * @Route("/show", name="question_show")
     */
    public function questionShowAction(Request $request)
    {
        // @TODO - get participant from session and db
        // @TODO - randomisation
        // @TODO - load vignette and question number from session info

        if( ($participantId=$this->get('session')->get('participant_id')) == null){
            return $this->redirectToRoute('homepage');
        }
        $participant = $this->getDoctrine()->getRepository('AppBundle:Participant')->find($participantId);

        $vignetteManager = $this->get('AppBundle\Manager\VignetteManager');
        $questionData = $vignetteManager->getQuestionData();
        $multiple = $vignetteManager->questionIsMultiple();

        $form = $this->createFormBuilder()
            ->add('answers', ChoiceType::class, [
                'label' => $questionData['text'],
                'choices' => array_flip($questionData['answers']),
                'expanded' => true,
                'multiple' => $multiple,
            ])
            ->add('save', SubmitType::class)
            ->getForm()
        ;
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData()['answers'];
            
            // When multiple is false, convert integer to array
            if(!is_array($data)){
                $data = [$data];
            }
            // Save answer
            $answer = new Answer(
                $participant,
                $vignetteManager->getVignetteId(), 
                $questionData['ref'], 
                $data
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            $vignetteManager->loadNextQuestion();

            return $this->redirectToRoute('question_show');
        }

        return $this->render('question/show.html.twig', [
            'form' => $form->createView(),
            'questionRef' => $questionData['ref'],
        ]);
    }
}