<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Participant;
use AppBundle\Manager\RandomizationManager;
use AppBundle\Model\Vignette;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/vignette")
 */
class VignetteController extends Controller
{

    /**
     * @Route("/question", name="vignette_question")
     */
    public function questionAction(Request $request)
    {
        // @TODO - randomisation
        // @TODO - load vignette and question number from session info

        if( ($participantId=$this->get('session')->get('participant_id')) == null){
            return $this->redirectToRoute('homepage');
        }
        $participant = $this->getDoctrine()->getRepository('AppBundle:Participant')->find($participantId);

        $vignetteManager = $this->get('AppBundle\Manager\VignetteManager');
        $questionData = $vignetteManager->getQuestionData();
        $description = $vignetteManager->getVignette()->getDescription();
        $multiple = $vignetteManager->questionIsMultiple();
        $vignetteKey = $vignetteManager->getVignetteKey();

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
            $valid = $vignetteManager->answerIsValid($data);
            // Save answer
            $answer = new Answer(
                $participant,
                $vignetteManager->getVignetteId(), 
                $questionData['ref'], 
                $data,
                $valid
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            // Load next question or next vignette
            $next = $vignetteManager->loadNextQuestion();
            if($next === 'NEXT_VIGNETTE'){
                return $this->redirectToRoute('vignette_description');
            }
            elseif($next === 'NEXT_QUESTION'){
                return $this->redirectToRoute('vignette_question');
            }

            // End of vignettes
            if($participant->getRandomizationGroup() == RandomizationManager::GROUP_CONTROL){
                return $this->redirectToRoute('end_control');
            }
            return $this->redirectToRoute('end_tool');
        }

        return $this->render('vignette/question.html.twig', [
            'form' => $form->createView(),
            'questionRef' => $questionData['ref'],
            'description' => $description,
            'vignetteKey' => $vignetteKey+1,
        ]);
    }


    /**
     * @Route("/description", name="vignette_description")
     */
    public function descriptionAction(Request $request)
    {
        $vignetteManager = $this->get('AppBundle\Manager\VignetteManager');
        $vignetteKey = $vignetteManager->getVignetteKey();

        return $this->render('vignette/description.html.twig', [
            'description' => $vignetteManager->getVignette()->getDescription(),
            'vignetteKey' => $vignetteKey+1,
        ]);
    }
}
