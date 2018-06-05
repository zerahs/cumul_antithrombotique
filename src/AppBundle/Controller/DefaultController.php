<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Form\ParticipantType;
use AppBundle\Manager\RandomizationManager;
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
        // @TODO clear session when participant finished all questions
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->add('save', SubmitType::class);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Randomization group
            $spe = $participant->getSpecialty();
            $manager = $this->get('AppBundle\Manager\RandomizationManager');
            if($spe == 'cardio'){
                $randomization = $manager->randomizeCardio();
            }
            elseif($spe == 'mg'){
                $randomization = $manager->randomizeMg();
            }
            else{
                // If not valid answers, redirect to exit
                return $this->redirectToRoute('exit');
            }
            $participant->setRandomizationNumber($randomization['number']);
            $participant->setRandomizationGroup($randomization['group']);

            // Randomize Vignettes
            if($participant->getRandomizationGroup() == RandomizationManager::GROUP_TOOL){
                $numbers = $manager->randomizeTool();
            }
            elseif($participant->getRandomizationGroup() == RandomizationManager::GROUP_CONTROL){
                $numbers = $manager->randomizeControl();
            }
            else{
                return $this->redirectToRoute('participant');
            }
            $participant->setVignetteNumbers($numbers);

            // Clear session and save participant
            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();
            $this->get('session')->clear();
            $this->get('session')->set('participant_id', $participant->getId());
            $this->get('session')->set('vignette_id', $numbers[0]);
            dump($participant);
            return $this->redirectToRoute('vignette_description');
        }

        return $this->render('default/participant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vignette/description", name="vignette_description")
     */
    public function vignetteDescriptionAction(Request $request)
    {
        $vignetteManager = $this->get('AppBundle\Manager\VignetteManager');

        return $this->render('default/vignette_description.html.twig', [
            'description' => $vignetteManager->getVignette()->getDescription(),
        ]);
    }

    /**
     * @Route("/exit", name="exit")
     */
    public function exitAction()
    {
        return $this->render('default/exit.html.twig', [
        ]);
    }
}
