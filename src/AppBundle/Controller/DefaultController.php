<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Form\ParticipantType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
        ]);
    }

    /**
     * @Route("/participant", name="participant")
     */
    public function participantAction(Request $request)
    {
        // @TODO redirect to questions if participant in session
    	$participant = new Participant();
    	$form = $this->createForm(ParticipantType::class, $participant);
    	$form->add('save', SubmitType::class);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            // If not valid answers, redirect to exit
            // TODO randomisation group with or without tool

            // Save participant to session
            $this->get('session')->set('participant_id', $participant->getId());

            return $this->redirectToRoute('question_show');
        }

        return $this->render('default/participant.html.twig', [
        	'form' => $form->createView(),
        ]);
    }
}
