<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Participant;
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
        $questionData = $this->questionData;
        $participant = $this->getDoctrine()->getRepository('AppBundle:Participant')->find(1);

        $form = $this->createFormBuilder()
            ->add('answers', ChoiceType::class, [
                'label' => $questionData['text'],
                'choices' => $questionData['answers'],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('save', SubmitType::class)
            ->getForm()
        ;
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData()['answers'];
            $answer = new Answer($participant, $questionData['id'], $data);
            
            dump($answer);
            // exit();
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
