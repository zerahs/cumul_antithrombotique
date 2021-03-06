<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participant;
use AppBundle\Entity\ToolReview;
use AppBundle\Form\ParticipantType;
use AppBundle\Form\ToolReviewType;
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
        $participantId = $this->get('session')->get('participant_id');
        return $this->render('default/index.html.twig', [
            'participantId' => $participantId,
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
            if($spe == 'cardioa' || $spe == 'cardiom'){
                $randomization = $manager->randomizeCardio();
            }
            elseif($spe == 'mga' || $spe == 'mgm'){
                $randomization = $manager->randomizeMg();
            }
            else{
                // If not valid answers, redirect to exit
                return $this->redirectToRoute('exit');
            }
            $participant->setRandomizationNumber($randomization['number']);
            $participant->setRandomizationGroup($randomization['group']);

            // Randomize Vignettes
            $numbers = $manager->randomizeVignettesByGroup($participant->getRandomizationGroup());
            $participant->setVignetteNumbers($numbers);

            // Clear session and save participant
            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();
            $this->get('session')->clear();
            $this->get('session')->set('participant_id', $participant->getId());
            $this->get('session')->set('vignette_key', 0);
            $this->get('session')->set('vignette_id', $numbers[0]);
            
            // Redirect to randomization group screen
            if($participant->getRandomizationGroup() == RandomizationManager::GROUP_CONTROL){
                return $this->redirectToRoute('group_control');
            }
            elseif($participant->getRandomizationGroup() == RandomizationManager::GROUP_TOOL){
                return $this->redirectToRoute('group_tool');
            }

            // @TODO error ? should not happen
            // return $this->redirectToRoute('participant');
        }

        return $this->render('default/participant.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/groupe-controle", name="group_control")
     */
    public function groupControlAction()
    {
        // If no participant, redirect to homepage
        if( ($participantId=$this->get('session')->get('participant_id')) == null){
            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/group_control.html.twig');
    }

    /**
     * @Route("/groupe-outil", name="group_tool")
     */
    public function groupToolAction()
    {
        // If no participant, redirect to homepage
        if( ($participantId=$this->get('session')->get('participant_id')) == null){
            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/group_tool.html.twig');
    }

    /**
     * @Route("/fin-controle", name="end_control")
     */
    public function endControlAction()
    {
        // If no participant, redirect to homepage
        if( ($participantId=$this->get('session')->get('participant_id')) == null){
            return $this->redirectToRoute('homepage');
        }
        // Reset session
        $this->get('session')->clear();

        return $this->render('default/end_control.html.twig');
    }

    /**
     * @Route("/fin-outil", name="end_tool")
     */
    public function endToolAction(Request $request)
    {
        // If no participant, redirect to homepage
        if( ($participantId=$this->get('session')->get('participant_id')) == null){
            return $this->redirectToRoute('homepage');
        }
        $review = new ToolReview();
        $participantId = $this->get('session')->get('participant_id');
        $form = $this->createForm(ToolReviewType::class, $review);
        $form->add('save', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => ['class' => 'btn btn-primary',],
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $participant = $em->getRepository('AppBundle:Participant')->find($participantId);

            $review->setParticipant($participant);
            $em->persist($review);
            $em->flush();
            $this->get('session')->clear();

            return $this->render('default/end_tool.html.twig');
        }

        return $this->render('default/end_tool.html.twig', [
            'form' => $form->createView(),
            'participantId' => $participantId,
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

    /**
     * @Route("/telecharger/outil", name="download_tool")
     */
    public function downloadToolAction()
    {
        $pdfPath = $this->getParameter('download_dir').'/combi-AT-outil.pdf';

        return $this->file($pdfPath);
    }

    /**
     * @Route("/telecharger/legende", name="download_caption")
     */
    public function downloadCaptionAction()
    {
        $pdfPath = $this->getParameter('download_dir').'/combi-AT-legende.pdf';

        return $this->file($pdfPath);
    }

    /**
     * @Route("/telecharger/exemples", name="download_examples")
     */
    public function downloadExamplesAction()
    {
        $pdfPath = $this->getParameter('download_dir').'/combi-AT-exemples.pdf';

        return $this->file($pdfPath);
    }
}
