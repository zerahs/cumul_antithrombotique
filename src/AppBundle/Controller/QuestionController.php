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
        // @TODO - get data from file
        // @TODO - get participant from session and db
        // @TODO - load question number from session info
        $vignette = $this->get('AppBundle\Model\Vignette');
        $vignette->load(1);
        $vignetteData = $vignette->getJson();
        $questionData = $vignetteData["questions"][3];
        $participant = $this->getDoctrine()->getRepository('AppBundle:Participant')->find(1);

        dump(array_flip($questionData['answers']));
        $form = $this->createFormBuilder()
            ->add('answers', ChoiceType::class, [
                'label' => $questionData['text'],
                'choices' => array_flip($questionData['answers']),
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('save', SubmitType::class)
            ->getForm()
        ;
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData()['answers'];
            $answer = new Answer($participant, $vignetteData['id'], $questionData['ref'], $data);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            // return $this->redirectToRoute('task_success');
        }

        return $this->render('question/show.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
